package com.fypool.controller.web;

import com.fypool.component.HelperController;
import com.fypool.model.*;
import com.fypool.repository.*;
import org.eclipse.sisu.plexus.Roles;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.security.Principal;
import java.util.ArrayList;
import java.util.List;


@Controller
public class CertificateController {

    @Autowired
    UserRepository userRepository;


    @Autowired
    CertificateRepository certificateRepository;


    @Autowired
    AdminCheckCertificateRepository adminCheckCertificateRepository;


    @Autowired
    EducationRepository educationRepository;

    @Autowired
    CertificatePictureRepository certificatePictureRepository;

    @Autowired
    CertificatePaperRepository certificatePaperRepository;

    @Autowired
    CertificateKindRepository certificateKindRepository;

    @Autowired
    TranslatePriceRepository translatePriceRepository;


    @Autowired
    SkilledFieldRepository skilledFieldRepository;

    @Autowired
    SkilledUsageRepository skilledUsageRepository;

    @Autowired
    LanguagesRepository languagesRepository;

    @Autowired
    LanguageGroupRepository languageGroupRepository;

    @Autowired
    HelperController helper;

    @Autowired
    MhCityRepository mhCityRepository;


    @Autowired
    CompanyRepository companyRepository;

    @Autowired
    CertificateInfoRepository certificateInfoRepository;

    @Autowired
    RoleRepository roleRepository;



    //用户访问认证视图
    @GetMapping("/user/certificate")
    public String certificate(Model model, HttpSession session) {
        session.setAttribute("menu","certificate");
        User user = (User) session.getAttribute("user");
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);
        if (check == null) {
            return "web/user/realname";
        } else {
            if (user.getCurrentRole().equals("ROLE_USER")) {
                //如果是译员
                if (check.getCertificateCheck() == null) {
                    model.addAttribute("languageGroups", languageGroupRepository.findAll());
                    return "web/user/educate";
                } else {
                    model.addAttribute("educations", educationRepository.findByUser(user));
                    model.addAttribute("pictures", certificatePictureRepository.findByUser(user));
                    model.addAttribute("papers", certificatePaperRepository.findByUser(user));
                    model.addAttribute("prices", translatePriceRepository.findByUser(user));
                    model.addAttribute("info", certificateInfoRepository.findByUser(user));
                    model.addAttribute("check", check);
                    model.addAttribute("certificate", certificateRepository.findByUser(user));
                    return "web/user/certificate";
                }
            } else {
                //如果是客户
                model.addAttribute("check", check);
                model.addAttribute("certificate", certificateRepository.findByUser(user));
                if (check.getCompanyCheck() == null) {
                    return "web/client/realname";
                } else {
                    model.addAttribute("company", companyRepository.findByUser(user));
                    return "web/client/certificate";
                }
            }
        }
    }

    //企业认证
    @GetMapping("/client/certificate")
    public String clientCertificate(Model model, HttpSession session) {
        User user = (User) session.getAttribute("user");
        Certificate certificate = certificateRepository.findByUser(user);
        model.addAttribute("certificate", certificate);
        return "web/client/company";
    }


    //用户实名认证
    @PostMapping("/user/name/certificate")
    public String userNameCertificate(
            HttpServletRequest request,
            Principal principal,
            @RequestParam(value = "idCardFront") MultipartFile idCardFront,
            @RequestParam(value = "idCardBack") MultipartFile idCardBack
    ) {
        User user = userRepository.findByUsername(principal.getName());
        //保存到数据库中
        Certificate certificate = new Certificate(
                request.getParameter("name"),
                mhCityRepository.findOne(Integer.valueOf(request.getParameter("province"))),
                mhCityRepository.findOne(Integer.valueOf(request.getParameter("city"))),
                mhCityRepository.findOne(Integer.valueOf(request.getParameter("area"))),
                request.getParameter("address"),
                request.getParameter("idNumber"),
                helper.uploadFile(idCardFront, "idCard"),
                helper.uploadFile(idCardBack, "idCard"),
                user
        );
        certificateRepository.save(certificate);
        //保存到数据库

        //创建管理员认证表，并把实名认证设置成正在审核
        AdminCheckCertificate check = new AdminCheckCertificate();

        check.setRealNameCheck(0);
        check.setUser(user);
        adminCheckCertificateRepository.save(check);

        //前去进行学历认证
        return "redirect:/user/certificate";
    }

    @PostMapping("/public/getAddress")
    public @ResponseBody
    String getAddress(HttpServletRequest request) {
        String province = mhCityRepository.findOne(Integer.valueOf(request.getParameter("province"))).getName();
        String city = mhCityRepository.findOne(Integer.valueOf(request.getParameter("city"))).getName();
        String area = mhCityRepository.findOne(Integer.valueOf(request.getParameter("area"))).getName();
        return province + city + area;
    }

    //上传学历照片，返回学历照片保存路径
    @PostMapping("/user/upload/educationPicture")
    public @ResponseBody
    String saveEducationPicture(
            @RequestParam("educationPicture") MultipartFile picture
    ) {
        return helper.uploadFile(picture, "education");
    }

    //上传资质照片，返回保存路径
    @PostMapping("/user/upload/certificatePicture")
    public @ResponseBody
    String saveCertificatePicture(
            @RequestParam("certificatePicture") MultipartFile picture
    ) {
        return helper.uploadFile(picture, "certificate");
    }

    //上传营业执照照片，返回保存路径
    @PostMapping("/user/upload/licensePicture")
    public @ResponseBody
    String saveLicensePicture(
            @RequestParam("licensePicture") MultipartFile picture
    ) {
        return helper.uploadFile(picture, "license");
    }

    //用户资质认证
    @PostMapping("/user/education/certificate")
    public String educationCertificate(
            HttpServletRequest request,
            HttpSession session,
            Principal principal,
            RedirectAttributes redirectAttributes
    ) {

        User user = userRepository.findByUsername(principal.getName());
        //保存到数据库中
        //保存学历
        String[] schools = request.getParameter("education").split(",");
        for (String item : schools) {
            String[] school = item.split("&");
            educationRepository.save(
                    new Education(school[0], school[1], school[2], school[3], Integer.valueOf(school[4]), Integer.valueOf(school[5]), user)
            );
        }

        //保存资质
        String[] certificates = request.getParameter("certificate").split(",");
        for (String item : certificates) {
            certificatePaperRepository.save(
                    new CertificatePaper(0, certificateKindRepository.findOne(Integer.valueOf(item)), user)
            );
        }

        //保存其他资质
        String[] otherCertificates = request.getParameter("otherCertificate").split(",");
        for (String item : otherCertificates) {
            certificatePaperRepository.save(
                    new CertificatePaper(1, item, user)
            );
        }

        //保存资质图片
        String[] certificatePictures = request.getParameter("certificatePictureUrl").split(",");
        for (String item : certificatePictures) {
            certificatePictureRepository.save(
                    new CertificatePicture(item, user)
            );
        }

        //保存翻译价格
        String[] prices = request.getParameter("price").split(",");
        for (String item : prices) {
            String[] price = item.split("&");
            translatePriceRepository.save(
                    new TranslatePrice(
                            price[1],
                            Integer.valueOf(price[2]),
                            price[3],
                            languageGroupRepository.findOne(Integer.valueOf(price[0])),
                            user)
            );
        }

        //保存工作年限和母语id
        CertificateInfo certificateInfo = new CertificateInfo();
        certificateInfo.setMotherTongue(languagesRepository.findOne(Integer.valueOf(request.getParameter("language"))));
        certificateInfo.setTranslateYear(Integer.valueOf(request.getParameter("translateYear")));
        certificateInfo.setUser(user);
        //擅长领域
        String[] skilledField = request.getParameter("skilledField").split(",");
        List<SkilledField> skilledFieldList = new ArrayList<>();
        for (String item : skilledField) {
            skilledFieldList.add(skilledFieldRepository.findOne(Integer.valueOf(item)));
        }
        certificateInfo.setSkilledFields(skilledFieldList);
        //擅长用途
        String[] skilledUsage = request.getParameter("skilledUsage").split(",");
        List<SkilledUsage> skilledUsageList = new ArrayList<>();
        for (String item : skilledUsage) {
            skilledUsageList.add(skilledUsageRepository.findOne(Integer.valueOf(item)));
        }
        certificateInfo.setSkilledUsages(skilledUsageList);
        certificateInfoRepository.save(certificateInfo);


        //添加到审核
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);
        check.setCertificateCheck(0);
        adminCheckCertificateRepository.save(check);

        redirectAttributes.addFlashAttribute("message", new Message(0, "译员认证提交成功，我们将会尽快审核"));

        return "redirect:/user/certificate";
    }


    //企业认证
    @PostMapping("/client/certificate")
    public String clientCertificate(
            HttpServletRequest request,
            HttpSession session,
            Principal principal,
            RedirectAttributes redirectAttributes
    ) {

        User user = userRepository.findByUsername(principal.getName());
        //保存到数据库中

        //保存企业图片
        String licensePicture = request.getParameter("licensePictureUrl");

        Company company = new Company(
                request.getParameter("company"),
                licensePicture,
                mhCityRepository.findOne(Integer.valueOf(request.getParameter("province"))),
                mhCityRepository.findOne(Integer.valueOf(request.getParameter("city"))),
                mhCityRepository.findOne(Integer.valueOf(request.getParameter("area"))),
                request.getParameter("address"),
                request.getParameter("contactName"),
                request.getParameter("contactPhone"),
                user
        );

        companyRepository.save(company);

        //添加到审核
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);
        check.setCompanyCheck(0);
        adminCheckCertificateRepository.save(check);

        redirectAttributes.addFlashAttribute("message", new Message(0, "企业认证提交成功，我们将会尽快审核"));

        return "redirect:/user/certificate";
    }


    //实名认证修改名字
    //只要不是返回视图的，都要添加@ResponseBody
    @PostMapping("/update/user/certificate")
    public String updateRealName(
            HttpServletRequest request,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");
        Certificate certificate = certificateRepository.findByUser(user);
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);

        String key = request.getParameter("key");
        switch (key) {
            case "name":
                if (check.getRealNameCheck() == 1) {
                    redirect.addFlashAttribute("nameMessage", new Message(0, "非法操作"));
                } else {
                    certificate.setName(request.getParameter("name"));
                    redirect.addFlashAttribute("nameMessage", new Message(1, "身份证姓名修改成功"));
                }

                break;
            case "address":
                if (check.getRealNameCheck() == 1) {
                    redirect.addFlashAttribute("nameMessage", new Message(0, "非法操作"));
                } else {
                    String[] areaIds = request.getParameter("provinceCityAreaId").split(",");
                    certificate.setProvince(mhCityRepository.findOne(Integer.valueOf(areaIds[0])));
                    certificate.setCity(mhCityRepository.findOne(Integer.valueOf(areaIds[1])));
                    certificate.setArea(mhCityRepository.findOne(Integer.valueOf(areaIds[2])));
                    certificate.setAddress(request.getParameter("address"));
                    redirect.addFlashAttribute("nameMessage", new Message(1, "身份证住址修改成功"));
                }

                break;
            case "idNumber":
                if (check.getRealNameCheck() == 1) {
                    redirect.addFlashAttribute("nameMessage", new Message(0, "非法操作"));
                } else {
                    certificate.setIdNumber(request.getParameter("idNumber"));
                    redirect.addFlashAttribute("nameMessage", new Message(1, "身份证号码修改成功"));
                }
                break;
        }

        certificateRepository.save(certificate);
        return "redirect:/user/certificate";
    }


    @GetMapping("/update/user/educate/translatePrice")
    public String updateTranslatePrice(
            Model model
    ) {
        model.addAttribute("languageGroups", languageGroupRepository.findAll());
        return "web/user/updateTranslatePrice";
    }

    //修改学历
    @PostMapping("/update/user/education")
    public String updateEducation(
            HttpServletRequest request,
            Principal principal,
            RedirectAttributes redirect
    ) {
        User user = userRepository.findByUsername(principal.getName());
        Certificate certificate = certificateRepository.findByUser(user);
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);
        List<Role> roles = null;

        String key = request.getParameter("key");
        CertificateInfo certificateInfo = certificateInfoRepository.findByUser(user);
        switch (key) {
            case "education":
                //删除用户的认证译员权限，并刷新缓存
                user.getRoles().remove(roleRepository.findByName("ROLE_AUTH_USER"));
                userRepository.save(user);

                SecurityContextHolder.getContext().setAuthentication(new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities()));

                //删除用户原先的学历
                educationRepository.deleteAllByUser(user);
                //保存用户新的学历
                String[] schools = request.getParameter("education").split(",");
                for (String item : schools) {
                    String[] school = item.split("&");
                    educationRepository.save(
                            new Education(school[0], school[1], school[2], school[3], Integer.valueOf(school[4]), Integer.valueOf(school[5]), user)
                    );
                }
                //无论处理什么阶段，全部要重新审核
                check.setCertificateCheck(0);
                redirect.addFlashAttribute("educationMessage", new Message(1, "学历修改成功！"));
                break;
            case "certificate":
                //删除用户的认证译员权限，并刷新缓存
                user.getRoles().remove(roleRepository.findByName("ROLE_AUTH_USER"));
                userRepository.save(user);
                SecurityContextHolder.getContext().setAuthentication(new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities()));

                //删除所有资质
                certificatePaperRepository.deleteAllByUser(user);
                //删除所有资质图片
                certificatePictureRepository.deleteAllByUser(user);

                //保存资质
                String[] certificates = request.getParameter("certificate").split(",");
                for (String item : certificates) {
                    certificatePaperRepository.save(
                            new CertificatePaper(0, certificateKindRepository.findOne(Integer.valueOf(item)), user)
                    );
                }

                //保存其他资质
                String[] otherCertificates = request.getParameter("otherCertificate").split(",");
                for (String item : otherCertificates) {
                    certificatePaperRepository.save(
                            new CertificatePaper(1, item, user)
                    );
                }

                //保存资质图片
                String[] certificatePictures = request.getParameter("certificatePictureUrl").split(",");
                for (String item : certificatePictures) {
                    certificatePictureRepository.save(
                            new CertificatePicture(item, user)
                    );
                }
                //无论处理什么阶段，全部要重新审核
                check.setCertificateCheck(0);
                redirect.addFlashAttribute("educationMessage", new Message(1, "资质证书及其图片修改成功"));
                break;
            case "translatePrice":
                //删除以前保存的价格
                translatePriceRepository.deleteAllByUser(user);
                //保存翻译价格
                String[] prices = request.getParameter("price").split(",");
                for (String item : prices) {
                    String[] price = item.split("&");
                    translatePriceRepository.save(
                            new TranslatePrice(
                                    price[1],
                                    Integer.valueOf(price[2]),
                                    price[3],
                                    languageGroupRepository.findOne(Integer.valueOf(price[0])),
                                    user)
                    );
                }
                redirect.addFlashAttribute("educationMessage", new Message(1, "翻译语言修改成功"));
                break;
            case "motherTongue":
                //保存母语
                certificateInfo.setMotherTongue(languagesRepository.findOne(Integer.valueOf(request.getParameter("language"))));
                certificateInfoRepository.save(certificateInfo);
                redirect.addFlashAttribute("educationMessage", new Message(1, "母语修改成功"));
                break;
            case "translateYear":
                //保存翻译年限
                certificateInfo.setTranslateYear(Integer.valueOf(request.getParameter("translateYear")));
                certificateInfoRepository.save(certificateInfo);
                redirect.addFlashAttribute("educationMessage", new Message(1, "翻译年限修改成功"));
                break;
            case "skilledField":
                //擅长领域
                String[] skilledField = request.getParameter("skilledField").split(",");
                List<SkilledField> skilledFieldList = new ArrayList<>();
                for (String item : skilledField) {
                    skilledFieldList.add(skilledFieldRepository.findOne(Integer.valueOf(item)));
                }
                certificateInfo.setSkilledFields(skilledFieldList);
                certificateInfoRepository.save(certificateInfo);
                redirect.addFlashAttribute("educationMessage", new Message(1, "擅长领域修改成功"));
                break;
            case "skilledUsage":
                //擅长领域
                String[] skilledUsage = request.getParameter("skilledUsage").split(",");
                List<SkilledUsage> skilledUsageList = new ArrayList<>();
                for (String item : skilledUsage) {
                    skilledUsageList.add(skilledUsageRepository.findOne(Integer.valueOf(item)));
                }
                certificateInfo.setSkilledUsages(skilledUsageList);
                certificateInfoRepository.save(certificateInfo);
                redirect.addFlashAttribute("educationMessage", new Message(1, "擅长用途修改成功"));
                break;
            default:
                break;
        }

        certificateRepository.save(certificate);
        return "redirect:/user/certificate?tab=2";
    }


    //修改企业信息
    @PostMapping("/update/client/company")
    public String updateCompany(
            HttpServletRequest request,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");
        Company company = companyRepository.findByUser(user);
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);

        String key = request.getParameter("key");
        switch (key) {
            case "name":
                if (check.getCompanyCheck() == 1) {
                    redirect.addFlashAttribute("companyMessage", new Message(0, "非法操作"));
                } else {
                    company.setName(request.getParameter("name"));
                    redirect.addFlashAttribute("companyMessage", new Message(1, "企业名称修改成功"));
                }
                break;
            case "license":
                if (check.getCompanyCheck() == 1) {
                    redirect.addFlashAttribute("companyMessage", new Message(0, "非法操作"));
                } else {
                    company.setLicense(request.getParameter("licensePictureUrl"));
                    redirect.addFlashAttribute("companyMessage", new Message(1, "营业执照修改成功"));
                }
                break;
            case "address":
                if (check.getCompanyCheck() == 1) {
                    redirect.addFlashAttribute("companyMessage", new Message(0, "非法操作"));
                } else {
                    String[] areaIds = request.getParameter("provinceCityAreaId").split(",");
                    company.setProvince(mhCityRepository.findOne(Integer.valueOf(areaIds[0])));
                    company.setCity(mhCityRepository.findOne(Integer.valueOf(areaIds[1])));
                    company.setArea(mhCityRepository.findOne(Integer.valueOf(areaIds[2])));
                    company.setAddress(request.getParameter("address"));
                    redirect.addFlashAttribute("companyMessage", new Message(1, "公司地址修改成功"));
                }
                break;
            case "contactName":
                company.setContactName(request.getParameter("contactName"));
                redirect.addFlashAttribute("companyMessage", new Message(1, "联系人姓名修改成功"));
                break;
            case "contactPhone":
                company.setContactPhone(request.getParameter("contactPhone"));
                redirect.addFlashAttribute("companyMessage", new Message(1, "联系方式修改成功"));
                break;
        }

        companyRepository.save(company);
        return "redirect:/user/certificate?tab=2";
    }

    //修改身份证照片
    @PostMapping("/update/user/certificate/idCard")
    public String updateIdCardPhoto(
            @RequestParam("idCardFront") MultipartFile idCardFront,
            @RequestParam("idCardBack") MultipartFile idCardBack,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");
        Certificate certificate = certificateRepository.findByUser(user);
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);
        if (check.getRealNameCheck() == 1) {
            redirect.addFlashAttribute("nameMessage", new Message(0, "非法操作"));
        } else {
            certificate.setIdCardFront(helper.uploadFile(idCardFront, "idCard"));
            certificate.setIdCardBack(helper.uploadFile(idCardBack, "idCard"));
            certificateRepository.save(certificate);
            redirect.addFlashAttribute("nameMessage", new Message(1, "身份证照片修改成功"));
        }
        return "redirect:/user/certificate";
    }

    //刷新认证证书，管理员认证通过，但用户的权限缓存没更新，所以要刷新
    @GetMapping("/refresh/certificate")
    public String refreshCertificate(Principal principal, RedirectAttributes redirect) {
        User user = userRepository.findByUsername(principal.getName());
        Authentication authentication = new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities());
        SecurityContextHolder.getContext().setAuthentication(authentication);
        redirect.addFlashAttribute("nameMessage", new Message(1, "成功更新认证证书"));
        return "redirect:/user/certificate";
    }

    //重新提交实名审核
    @GetMapping("/resubmit/certificate")
    public String resubmitCertificate(Principal principal, RedirectAttributes redirect) {
        User user = userRepository.findByUsername(principal.getName());
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);
        //将审核重新提交
        check.setRealNameCheck(0);
        adminCheckCertificateRepository.save(check);
        redirect.addFlashAttribute("nameMessage", new Message(1, "已重新提交审核"));
        return "redirect:/user/certificate";
    }

    //重新提交译员认证审核
    @GetMapping("/resubmit/education")
    public String resubmitEducation(Principal principal, RedirectAttributes redirect) {
        User user = userRepository.findByUsername(principal.getName());
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);
        //将审核重新提交
        check.setCertificateCheck(0);
        adminCheckCertificateRepository.save(check);
        redirect.addFlashAttribute("educationMessage", new Message(1, "已重新提交审核"));
        return "redirect:/user/certificate?tab=2";
    }

    //重新提交企业认证审核
    @GetMapping("/resubmit/company")
    public String resubmitCompany(Principal principal, RedirectAttributes redirect) {
        User user = userRepository.findByUsername(principal.getName());
        AdminCheckCertificate check = adminCheckCertificateRepository.findByUser(user);
        //将审核重新提交
        check.setCompanyCheck(0);
        adminCheckCertificateRepository.save(check);
        redirect.addFlashAttribute("companyMessage", new Message(1, "已重新提交审核"));
        return "redirect:/user/certificate?tab=2";
    }

}


