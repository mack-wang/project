package com.fypool.component;


import com.fypool.controller.web.UserController;
import com.fypool.model.*;
import com.fypool.repository.*;
import com.sun.mail.util.MailSSLSocketFactory;
import me.chanjar.weixin.common.exception.WxErrorException;
import me.chanjar.weixin.mp.api.WxMpService;
import me.chanjar.weixin.mp.bean.template.WxMpTemplateData;
import me.chanjar.weixin.mp.bean.template.WxMpTemplateMessage;
import org.apache.commons.io.FileUtils;
import org.hashids.Hashids;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.core.env.Environment;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.data.redis.core.ValueOperations;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Component;
import org.springframework.stereotype.Controller;
import org.springframework.util.Base64Utils;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;
import org.stringtemplate.v4.ST;
import org.thymeleaf.context.Context;
import org.thymeleaf.spring4.SpringTemplateEngine;

import javax.mail.Authenticator;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.MimeMessage;
import javax.servlet.http.HttpSession;
import java.io.File;
import java.io.IOException;
import java.math.BigDecimal;
import java.security.GeneralSecurityException;
import java.security.Principal;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.*;
import java.util.concurrent.TimeUnit;


@Component
public class HelperController {

    @Value("${customer.upload.path}")
    String uploadpath;

    @Autowired
    private RedisTemplate redisTemplate;

    @Autowired
    ReadFileUtils readFileUtils;

    @Autowired
    AccountingRepository accountingRepository;

    @Autowired
    AccountRepository accountRepository;

    @Autowired
    BalanceRepository balanceRepository;

    @Autowired
    UserRepository userRepository;

    @Autowired
    CertificateRepository certificateRepository;

    @Value("${spring.mail.username}")
    private String username;//登录用户名
    @Value("${spring.mail.password}")
    private String password;        //登录密码
    @Value("${spring.mail.from}")
    private String from;        //发件地址
    @Value("${spring.mail.host}")
    private String host;        //服务器地址
    @Value("${spring.mail.port}")
    private String port;        //端口
    @Value("${spring.mail.protocol}")
    private String protocol; //协议

    //使用thymeleaf作为邮件模板
    @Autowired
    SpringTemplateEngine springTemplateEngine;

    @Autowired
    BillRepository billRepository;

    @Value("${domain.url}")
    String domainUrl;

    @Autowired
    WxMpService wxMpService;


    public String uploadFile(MultipartFile file, String folder) {
        String path;

        if (file.isEmpty()) {
            return "fileIsEmpty";
        } else {
            // 获取文件名
            String fileName = file.getOriginalFilename();
            // 获取文件的后缀名
            String suffixName = fileName.substring(fileName.lastIndexOf("."));
            // 文件上传后的路径
            Date date = new Date();
            DateFormat format = new SimpleDateFormat("yyyy-MM-dd");
            String time = format.format(date);
            String filePath = uploadpath + folder + "/" + time + "/";

            // 解决中文问题，liunx下中文路径，图片显示问题
            fileName = UUID.randomUUID() + suffixName;

            File dest = new File(filePath + fileName);
            // 检测是否存在目录
            if (!dest.getParentFile().exists()) {
                dest.getParentFile().mkdirs();
            }

            try {
                file.transferTo(dest);
            } catch (IllegalStateException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            path = "/upload/" + folder + "/" + time + "/" + fileName;
        }

        return path;
    }


    public String uploadImgBase64(String base64Data, String folder) {
        String path = "";
        String dataPrix;
        String data;

        try {
            if (base64Data == null || "".equals(base64Data)) {
                throw new Exception("上传失败，上传图片数据为空");
            } else {
                String[] d = base64Data.split("base64,");
                if (d != null && d.length == 2) {
                    dataPrix = d[0];
                    data = d[1];
                } else {
                    throw new Exception("上传失败，数据不合法");
                }
            }

            String suffix;
            if ("data:image/jpeg;".equalsIgnoreCase(dataPrix)) {
                //data:image/jpeg;base64,base64编码的jpeg图片数据
                suffix = ".jpg";
            } else if ("data:image/x-icon;".equalsIgnoreCase(dataPrix)) {
                //data:image/x-icon;base64,base64编码的icon图片数据
                suffix = ".ico";
            } else if ("data:image/gif;".equalsIgnoreCase(dataPrix)) {
                //data:image/gif;base64,base64编码的gif图片数据
                suffix = ".gif";
            } else if ("data:image/png;".equalsIgnoreCase(dataPrix)) {
                //data:image/png;base64,base64编码的png图片数据
                suffix = ".png";
            } else {
                throw new Exception("上传图片格式不合法");
            }
            String fileName = UUID.randomUUID() + suffix;

            //因为BASE64Decoder的jar问题，此处使用spring框架提供的工具包
            byte[] bs = Base64Utils.decodeFromString(data);

            // 文件上传后的路径
            Date date = new Date();
            DateFormat format = new SimpleDateFormat("yyyy-MM-dd");
            String time = format.format(date);
            String filePath = uploadpath + folder + "/" + time + "/";
            path = "/upload/" + folder + "/" + time + "/" + fileName;
            try {
                //使用apache提供的工具类操作流
                FileUtils.writeByteArrayToFile(new File(filePath + fileName), bs);

            } catch (Exception e) {
                e.printStackTrace();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return path;

    }

    //检查短信验证码
    public boolean verifySms(String phone, Integer sms) {
        if (phone.length() != 11) {
            return false;
        }
        //把用户的短信储存到数据库，并缓存到redis，
        //验证有效期5分钟、允许重新获取并覆盖短信时间1分钟
        if (!this.redisTemplate.hasKey("sms:" + phone)) return false;
        Object result = this.redisTemplate.opsForValue().get("sms:" + phone);

        ValueOperations<String, Integer> ops = this.redisTemplate.opsForValue();

        //从缓存中查找验证码，若存在且和用户输入的一样，则验证通过
        if (result.equals(sms)) {
            //若有错误记录，则检查错误次数
            if (this.redisTemplate.hasKey("error:" + phone)) {
                Integer count = ops.get("error:" + phone);
                if (count > 10) {
                    return false;
                }
                //错误次数少于10次，验证码又正确，则删除错误记录
                this.redisTemplate.delete("error:" + phone);
            }
            //验证成功后删除短信验证码
            this.redisTemplate.delete("sms:" + phone);
            return true;
        } else {
            if (this.redisTemplate.hasKey("error:" + phone)) {
                Integer count = ops.get("error:" + phone);
                if (count > 10) {
                    return false;
                }
                //若短信验证码超过10次验证失败，则拉黑2小时
                ops.set("error:" + phone, ++count, 2 * 60 * 60, TimeUnit.SECONDS);
            } else {
                //若首次出现验证码错误，则创建错误次数记录
                ops.set("error:" + phone, 1, 2 * 60 * 60, TimeUnit.SECONDS);
            }

            return false;
        }
    }

    //上传文件并统计字数
    //type为统计字数的类型，words单词型统计（默认）, chars字符型统计（日语、韩语、中文）
    public Map<String, String> uploadFileAndCountWord(MultipartFile file, String folder, String type) {
        //返回status 具体情况（success,file_error..） message 提示语 word 字符数 path 路径
        String path;
        String suffixName;
        String uuid;
        Map<String, Integer> detail = new HashMap<>();
        Map<String, String> map = new HashMap<>();
        if (file.isEmpty()) {
            map.put("status", "fileIsEmpty");
            map.put("message", "文件不能为空");
            return map;
        } else {
            // 获取文件名
            String fileName = file.getOriginalFilename();
            // 获取文件的后缀名
            suffixName = fileName.substring(fileName.lastIndexOf("."));

            // 文件上传后的路径
            Date date = new Date();
            DateFormat format = new SimpleDateFormat("yyyy-MM-dd");
            String time = format.format(date);

            //因为我保留了文件名，所以要通过文件夹名字的不同来避免覆盖　
            uuid = String.valueOf(UUID.randomUUID());
            String filePath = uploadpath + folder + "/" + time + "/" + uuid + "/";

            //保存fileName，因为我还要显示正常的文件名
            String finalPath = filePath + fileName;
            File dest = new File(finalPath);
            // 检测是否存在目录
            if (!dest.getParentFile().exists()) {
                dest.getParentFile().mkdirs();
            }

            try {
                file.transferTo(dest);
                //获取文件的页数，字数，字符数 pages,words,chars
                try {
                    switch (suffixName) {
                        case ".doc":
                            detail = readFileUtils.readWORDDetail(finalPath);
                            break;
                        case ".docx":
                            detail = readFileUtils.readWORD2007Detail(finalPath);
                            break;
                        case ".pdf":
                            detail = readFileUtils.readPDFDetail(finalPath);
                            break;
                        case ".txt":
                            detail = readFileUtils.readTXTDetail(finalPath);
                            break;
                        case ".xls":
                            detail = readFileUtils.readEXCELDetail(finalPath);
                            break;
                        case ".xlsx":
                            detail = readFileUtils.readEXCEL2007Detail(finalPath);
                            break;
                        case ".ppt":
                            detail = readFileUtils.readPPTDetail(finalPath);
                            break;
                        case ".pptx":
                            detail = readFileUtils.readPPT2007Detail(finalPath);
                            break;
                        default:
                            break;
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                }
            } catch (IllegalStateException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            path = "/upload/" + folder + "/" + time + "/" + uuid + "/" + fileName;
        }
        map.put("status", "success");
        map.put("message", "文件上传成功");
        map.put("path", path);
        map.put("suffixName", suffixName);//后缀，让前端显示不同的图标
        map.put("type", type);//判断是char类型语言中文日语韩语，还是word类型语言英语法语德语
        map.put("size", String.valueOf(file.getSize()));
        map.put("uuid", uuid);//作为redis的key
        if (!detail.isEmpty()) {
            map.put("hasCount", "true");//文件字数能否数出
            map.put("pages", String.valueOf(detail.get("pages")));
            map.put("chars", String.valueOf(detail.get("chars")));
            map.put("words", String.valueOf(detail.get("words")));
        } else {
            map.put("hasCount", "false");
            map.put("pages", String.valueOf(0));
            map.put("chars", String.valueOf(0));
            map.put("words", String.valueOf(0));
        }
        return map;
    }

    //2017/08/09 12:23 转成标准日期
    public Date parseDate(String dataStr) {
        Date date = new Date();
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy/MM/dd HH:mm");
        try {
            date = sdf.parse(dataStr);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        return date;
    }

    //根据两个日期，计算天数,精确到2位小数
    public BigDecimal getDay(Date start, Date end) {
        BigDecimal difference = new BigDecimal(end.getTime() - start.getTime());//毫秒
        BigDecimal dayTime = new BigDecimal(1000 * 60 * 60 * 24);
        return difference.divide(dayTime, 2, BigDecimal.ROUND_HALF_UP);
    }


    //每笔款的安全，由每笔款发生的控制器和方法来负责，就是检查这笔款是否支出大于收入，或者是否已经发生！
    //保存账单，流水，交易记录
    public void saveBalance(BigDecimal variation, User user, String accountingShortName, Task task) {
        Accounting accounting = accountingRepository.findByShortName(accountingShortName);
        Account account = user.getAccount();
        BigDecimal money = account.getMoney();
        //1 是有的意思，代表平台是收入，用户是支出，所以用户金额应该是减
        //用户充值，类型应该是0，用户收入，所以用户要加
        //平台的收入只有佣金和置顶费用
        if (accounting.getType() == 1) {
            money = money.subtract(variation);
        } else {
            money = money.add(variation);
        }
        Balance balance = new Balance(accounting, user, variation, money);
        if (task != null) {
            balance.setTask(task);
        }
        balanceRepository.save(balance);
        //由于没有级联，所以这里应该要accountRepository保存account
        account.setMoney(money);
        accountRepository.save(account);
    }

    public void saveBalanceForProduct(BigDecimal variation, User user, String accountingShortName, Product product) {
        Accounting accounting = accountingRepository.findByShortName(accountingShortName);
        Account account = user.getAccount();
        BigDecimal money = account.getMoney();
        if (accounting.getType() == 1) {
            money = money.subtract(variation);
        } else {
            money = money.add(variation);
        }
        Balance balance = new Balance(accounting, user, variation, money);
        if (product != null) {
            balance.setProduct(product);
        }
        balanceRepository.save(balance);
        account.setMoney(money);
        accountRepository.save(account);
    }

    public void saveBill(BigDecimal variation, User user, String accountingShortName, Bill bill) {
        Accounting accounting = accountingRepository.findByShortName(accountingShortName);
        Account account = user.getAccount();
        BigDecimal money = account.getMoney();
        if (accounting.getType() == 1) {
            money = money.subtract(variation);
        } else {
            money = money.add(variation);
        }
        Balance balance = new Balance(accounting, user, variation, money);
        balance.setBill(bill);
        balanceRepository.save(balance);

        //由于没有级联，所以这里应该要accountRepository保存account
        account.setMoney(money);
        accountRepository.save(account);

        //将账单设置为已经支付
        bill.setPay(1);
        billRepository.save(bill);
    }

    //每笔款的安全，由每笔款发生的控制器和方法来负责，就是检查这笔款是否支出大于收入，或者是否已经发生！
    //平方收款交易记录保存
    public void saveBalanceForFanyi(BigDecimal variation, String accountingShortName, Task task) {
        Accounting accounting = accountingRepository.findByShortName(accountingShortName);
        Balance balance = new Balance(accounting, variation);
        if (task != null) {
            balance.setTask(task);
        }
        balanceRepository.save(balance);
    }

    public void saveBalanceForTicket(BigDecimal variation, User user, String accountingShortName, Task task, Ticket ticket) {
        Accounting accounting = accountingRepository.findByShortName(accountingShortName);
        Account account = user.getAccount();
        BigDecimal money = account.getMoney();
        //增加钱
        money = money.add(variation);
        Balance balance = new Balance(accounting, user, variation, money);
        if (task != null) {
            balance.setTask(task);
        }
        //关联优惠券
        balance.setTicket(ticket);
        balanceRepository.save(balance);

        account.setMoney(money);
        accountRepository.save(account);
    }

    //检查支付密码是否正确
    public Message checkPayPassword(BigDecimal price, User user, String password) {
        Integer payErrorCount = 0;
        String key = "payError:" + user.getUsername();
        ValueOperations<String, Integer> ops = redisTemplate.opsForValue();

        //检查之前是否有支付密码错误
        if (redisTemplate.hasKey(key)) {
            payErrorCount = ops.get(key);
            if (payErrorCount > 3) {
                return new Message(0, "支付密码错误次数过多，账号已经被锁定2小时.");
            }
        }

        String password1 = user.getAccount().getPassword();

        if (password1 == null) {
            ops.set("payError:" + user.getUsername(), ++payErrorCount, 60 * 60 * 2, TimeUnit.SECONDS);//锁住两小时
            return new Message(0, "未设置支付密码，请到个人信息-安全设置-支付密码中设置");
        }

        //检查支付密码是否正确，余额，错误次数
        BCryptPasswordEncoder crypt = new BCryptPasswordEncoder();
        if (!crypt.matches(password, password1)) {
            ops.set("payError:" + user.getUsername(), ++payErrorCount, 60 * 60 * 2, TimeUnit.SECONDS);//锁住两小时
            return new Message(0, "支付密码错误");
        }

        //检查余额
        BigDecimal money = user.getAccount().getMoney();
        if (money.compareTo(price) == -1) {
            return new Message(0, "余额不足");
        }

        return new Message(1, "验证成功");
    }


    //发送邮件
    static class MyAuthenricator extends Authenticator {
        String u = null;
        String p = null;

        public MyAuthenricator(String u, String p) {
            this.u = u;
            this.p = p;
        }

        @Override
        public PasswordAuthentication getPasswordAuthentication() {
            return new PasswordAuthentication(u, p);
        }
    }

    private Properties getProp() {
        //腾讯企业邮箱
        Properties prop = new Properties();
        //协议
        prop.setProperty("mail.transport.protocol", protocol);
        //服务器
        prop.setProperty("mail.smtp.host", host);
        //端口
        prop.setProperty("mail.smtp.port", port);
        //使用smtp身份验证
        prop.setProperty("mail.smtp.auth", "true");
        //使用SSL，企业邮箱必需！
        //开启安全协议
        MailSSLSocketFactory sf = null;
        try {
            sf = new MailSSLSocketFactory();
            sf.setTrustAllHosts(true);
        } catch (GeneralSecurityException e1) {
            e1.printStackTrace();
        }
        prop.put("mail.smtp.ssl.enable", "true");
        prop.put("mail.smtp.ssl.socketFactory", sf);
        return prop;
    }


    //发送普通文字通知类邮件
    public Boolean sendEmail(String email, String title, String content, User user) {
        String head = "您好！";
        String sex = "";
        if (user != null) {
            Certificate certificate = certificateRepository.findByUser(user);
            if (certificate == null) {
                Integer sexNumber = user.getUserInfo().getSex();
                if (sexNumber != null) {
                    if (sexNumber == 0) {
                        sex = "女士";
                    } else {
                        sex = "先生";
                    }
                }
                head = certificate.getName() + sex + "," + head;
            } else {
                head = user.getAttribute().getNickname() + "," + head;
            }
        }

        Properties prop = getProp();

        Session sessions = Session.getDefaultInstance(prop, new MyAuthenricator(username, password));
        sessions.setDebug(true);
        MimeMessage message = new MimeMessage(sessions);
        try {
            //如果不加UTF-8的话，会乱码　
            MimeMessageHelper helper = new MimeMessageHelper(message, true, "UTF-8");
            helper.setFrom(from);//邮件发送者
            helper.setTo(email);//邮件接收者
            helper.setSubject(title);

            //使用thymeleaf作为邮箱模板
            Context context = new Context();

            //设置变量
            context.setVariable("head", head);
            context.setVariable("content", content);
            context.setVariable("title", title);

            //发送thymeleaf模板
            String emailContent = springTemplateEngine.process("email/emailRespond", context);
            helper.setText(emailContent, true);

            //原先用javaMailSender来发邮件，在企业邮箱下不起作用，所以换了Transport
            Transport.send(message);
        } catch (Exception e) {
            e.printStackTrace();
        }

        return true;
    }

    //发送vip任务账单
    public Boolean sendEmailBill(String email, String title, Bill bill, User user) {
        String head = "您好！";
        String sex = "";
        if (user != null) {
            Certificate certificate = certificateRepository.findByUser(user);
            if (certificate == null) {
                Integer sexNumber = user.getUserInfo().getSex();
                if (sexNumber != null) {
                    if (sexNumber == 0) {
                        sex = "女士";
                    } else {
                        sex = "先生";
                    }
                }
                head = certificate.getName() + sex + "," + head;
            } else {
                head = user.getAttribute().getNickname() + "," + head;
            }
        }

        Properties prop = getProp();

        Session sessions = Session.getDefaultInstance(prop, new MyAuthenricator(username, password));
        sessions.setDebug(true);
        MimeMessage message = new MimeMessage(sessions);
        try {
            //如果不加UTF-8的话，会乱码　
            MimeMessageHelper helper = new MimeMessageHelper(message, true, "UTF-8");
            helper.setFrom(from);//邮件发送者
            helper.setTo(email);//邮件接收者
            helper.setSubject(title);

            //使用thymeleaf作为邮箱模板
            Context context = new Context();

            //设置变量
            context.setVariable("head", head);
            context.setVariable("bill", bill);
            context.setVariable("title", title);

            //发送thymeleaf模板
            String emailContent = springTemplateEngine.process("email/emailBill", context);
            helper.setText(emailContent, true);

            //原先用javaMailSender来发邮件，在企业邮箱下不起作用，所以换了Transport
            Transport.send(message);
        } catch (Exception e) {
            e.printStackTrace();
        }

        return true;
    }

    //验证图形验证码
    //ajax验证图形验证码是否正确
    public Boolean captchaCheck(
            String captcha,
            HttpSession session
    ) {
        String key = session.getAttribute("captchaKey").toString();
        ValueOperations<String, String> ops = redisTemplate.opsForValue();
        String getCaptcha = ops.get(key);
        //忽略大小写，比较字符串
        if (captcha.equalsIgnoreCase(getCaptcha)) {
            return true;
        } else {
            return false;
        }
    }

    //发送微信模板消息
    public void sendWechatMessage(String openId,String uri,String first,String type,String title,String nickname,String status,String remark) throws WxErrorException {
        Date date = new Date();
        DateFormat format = new SimpleDateFormat("yyyy-MM-dd");
        String time = format.format(date);
        //如果发布者绑定了微信公众号
        WxMpTemplateMessage templateMessage = new WxMpTemplateMessage();
        templateMessage.setToUser(openId);
        templateMessage.setTemplateId("haGJ4cS0KLOhenkQmITvQRNe0_rVxpVkxauXbOqgMD4");
        //点击跳转到微信任务列表
        templateMessage.setUrl(domainUrl+"/wechat/auth/process");
        templateMessage.getData().add(new WxMpTemplateData("first", first, "#0070C9"));
        templateMessage.getData().add(new WxMpTemplateData("keyword1", type, "#0070C9"));
        templateMessage.getData().add(new WxMpTemplateData("keyword2", title, "#0070C9"));
        templateMessage.getData().add(new WxMpTemplateData("keyword3", nickname, "#0070C9"));
        templateMessage.getData().add(new WxMpTemplateData("keyword4", status, "#0070C9"));
        templateMessage.getData().add(new WxMpTemplateData("keyword5", time, "#0070C9"));
        templateMessage.getData().add(new WxMpTemplateData("remark", remark, "#0070C9"));
        wxMpService.getTemplateMsgService().sendTemplateMsg(templateMessage);
    }


}
