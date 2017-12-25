package com.fypool.controller.web;

import com.fypool.model.CertificatePicture;
import com.fypool.model.FileClean;
import com.fypool.repository.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.core.io.Resource;
import org.springframework.core.io.support.ResourcePatternResolver;
import org.springframework.stereotype.Controller;
import org.springframework.util.ResourceUtils;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ResponseBody;

import java.io.File;

@Controller
public class FileCleanController {
    @Autowired
    AttributeRepository attributeRepository;


    //这个类，可以用来读取/* /** /*/* 匹配型的目录和文件
    @Autowired
    ResourcePatternResolver resourcePatternResolver;

    @Autowired
    FileCleanRepository fileCleanRepository;

    @Autowired
    AttachmentRepository attachmentRepository;

    @Autowired
    CertificatePictureRepository certificatePictureRepository;

    @Autowired
    CertificateRepository certificateRepository;

    @Autowired
    VipRepository vipRepository;

    @Value("${customer.upload.path}")
    String uploadpath;

    @Autowired
    CompanyRepository companyRepository;

    @Autowired
    VipTaskRepository vipTaskRepository;

    @Autowired
    ProcessRepository processRepository;



    //清理用户上传的多余的头像
    @GetMapping("/admin/clean/avatar")
    public @ResponseBody FileClean cleanAvatar(){
        Integer counts = 0;//清理文件的数量
        String folder = "avatar";
        Long size = 0L;
        FileClean fileClean = null;

        try{
            //使用/*/*只读取日期目录下的文件，而不会把目录删除，而/**会包含目录
            //只删除src下的upload就可以，不要管target下的，因为target只在编译的时候会载入文件，平常用户再上传，引用的还是src下的文件
            Resource[] resources = resourcePatternResolver.getResources("file:"+uploadpath+"avatar/*/*");
            for(Resource resource:resources){
                //获取完整的url,大概长这样file:/User/Wanglecheng/...
                String url = resource.getURL().toString();
                //截取和数据库匹配的路径
                Integer index = url.lastIndexOf("/upload");
                String uri = url.substring(index);
                //从数据库中检查文件是否存在
                Boolean result = attributeRepository.existsByAvatar(uri);
                //如果不存在，就删除该文件
                if(!result){
                    File file = resource.getFile();
                    counts++;
                    size = size + file.length();
                    file.delete();
                }
            }

            //保存清理的记录
            fileClean = new FileClean(size,folder,counts);
            fileCleanRepository.save(fileClean);

        }catch (Exception e){
            e.printStackTrace();
        }
        return fileClean;
    }

    //清理用户上传的多余的附件
    @GetMapping("/admin/clean/attachment")
    public @ResponseBody FileClean cleanAttachment(){
        Integer counts = 0;//清理文件的数量
        String folder = "attachment";
        Long size = 0L;
        FileClean fileClean = null;
        try{
            Resource[] resources = resourcePatternResolver.getResources("file:"+uploadpath+"attachment/*/*/*");
            for(Resource resource:resources){
                String url = resource.getURL().toString();
                Integer index = url.lastIndexOf("/upload");
                String uri = url.substring(index);
                Boolean result = attachmentRepository.existsByPath(uri);
                if(!result){
                    File file = resource.getFile();
                    counts++;
                    size = size + file.length();
                    file.delete();
                }
            }
            fileClean = new FileClean(size,folder,counts);
            fileCleanRepository.save(fileClean);
        }catch (Exception e){
            e.printStackTrace();
        }
        return fileClean;
    }

    //清理译员上传的多余的资质认证证书
    @GetMapping("/admin/clean/certificate")
    public @ResponseBody FileClean cleanCertificate(){
        Integer counts = 0;//清理文件的数量
        String folder = "certificate";
        Long size = 0L;
        FileClean fileClean = null;
        try{
            Resource[] resources = resourcePatternResolver.getResources("file:"+uploadpath+"certificate/*/*");
            for(Resource resource:resources){
                String url = resource.getURL().toString();
                Integer index = url.lastIndexOf("/upload");
                String uri = url.substring(index);
                Boolean result = certificatePictureRepository.existsByPath(uri);
                if(!result){
                    File file = resource.getFile();
                    counts++;
                    size = size + file.length();
                    file.delete();
                }
            }
            fileClean = new FileClean(size,folder,counts);
            fileCleanRepository.save(fileClean);
        }catch (Exception e){
            e.printStackTrace();
        }
        return fileClean;
    }

    //删除多余身份证
    @GetMapping("/admin/clean/idCard")
    public @ResponseBody FileClean cleanIdCard(){
        Integer counts = 0;//清理文件的数量
        String folder = "idCard";
        Long size = 0L;
        FileClean fileClean = null;
        try{
            Resource[] resources = resourcePatternResolver.getResources("file:"+uploadpath+"idCard/*/*");
            for(Resource resource:resources){
                String url = resource.getURL().toString();
                Integer index = url.lastIndexOf("/upload");
                String uri = url.substring(index);
                Boolean result = certificateRepository.existsByIdCardBackOrIdCardFront(uri,uri);
                if(!result){
                    File file = resource.getFile();
                    counts++;
                    size = size + file.length();
                    file.delete();
                }
            }
            fileClean = new FileClean(size,folder,counts);
            fileCleanRepository.save(fileClean);
        }catch (Exception e){
            e.printStackTrace();
        }
        return fileClean;
    }

    //删除多余营业执照
    @GetMapping("/admin/clean/license")
    public @ResponseBody FileClean cleanLicense(){
        Integer counts = 0;//清理文件的数量
        String folder = "license";
        Long size = 0L;
        FileClean fileClean = null;
        try{
            Resource[] resources = resourcePatternResolver.getResources("file:"+uploadpath+"license/*/*");
            for(Resource resource:resources){
                String url = resource.getURL().toString();
                Integer index = url.lastIndexOf("/upload");
                String uri = url.substring(index);
                Boolean result = companyRepository.existsByLicense(uri);
                if(!result){
                    File file = resource.getFile();
                    counts++;
                    size = size + file.length();
                    file.delete();
                }
            }
            fileClean = new FileClean(size,folder,counts);
            fileCleanRepository.save(fileClean);
        }catch (Exception e){
            e.printStackTrace();
        }
        return fileClean;
    }

    //删除多余vip任务原稿附件
    @GetMapping("/admin/clean/vipAttachment")
    public @ResponseBody FileClean cleanVipAttachment(){
        Integer counts = 0;//清理文件的数量
        String folder = "vipAttachment";
        Long size = 0L;
        FileClean fileClean = null;
        try{
            Resource[] resources = resourcePatternResolver.getResources("file:"+uploadpath+"vipAttachment/*/*");
            for(Resource resource:resources){
                String url = resource.getURL().toString();
                Integer index = url.lastIndexOf("/upload");
                String uri = url.substring(index);
                Boolean result = vipTaskRepository.existsByVipAttachment(uri);
                if(!result){
                    File file = resource.getFile();
                    counts++;
                    size = size + file.length();
                    file.delete();
                }
            }
            fileClean = new FileClean(size,folder,counts);
            fileCleanRepository.save(fileClean);
        }catch (Exception e){
            e.printStackTrace();
        }
        return fileClean;
    }

    //删除多余vip任务译稿
    @GetMapping("/admin/clean/vipTask")
    public @ResponseBody FileClean cleanVipTask(){
        Integer counts = 0;//清理文件的数量
        String folder = "vipTask";
        Long size = 0L;
        FileClean fileClean = null;
        try{
            Resource[] resources = resourcePatternResolver.getResources("file:"+uploadpath+"vipTask/*/*");
            for(Resource resource:resources){
                String url = resource.getURL().toString();
                Integer index = url.lastIndexOf("/upload");
                String uri = url.substring(index);
                Boolean result = vipTaskRepository.existsByVipTask(uri);
                if(!result){
                    File file = resource.getFile();
                    counts++;
                    size = size + file.length();
                    file.delete();
                }
            }
            fileClean = new FileClean(size,folder,counts);
            fileCleanRepository.save(fileClean);
        }catch (Exception e){
            e.printStackTrace();
        }
        return fileClean;
    }

    //删除过期的二维码
    @GetMapping("/admin/clean/qrcode")
    public @ResponseBody FileClean cleanQrcode(){
        Integer counts = 0;//清理文件的数量
        String folder = "qrcode";
        Long size = 0L;
        FileClean fileClean = null;
        try{
            Resource[] resources = resourcePatternResolver.getResources("file:"+uploadpath+"qrcode/*");
            for(Resource resource:resources){
                File file = resource.getFile();
                //file.lastModified() 1510835722000 毫秒数
                //如果二维码超过一天，则删除
                if((file.lastModified()+86400000L)<System.currentTimeMillis()){
                    counts++;
                    size = size + file.length();
                    file.delete();
                }
            }
            fileClean = new FileClean(size,folder,counts);
            fileCleanRepository.save(fileClean);
        }catch (Exception e){
            e.printStackTrace();
        }
        return fileClean;
    }

    //删除用户的修改建议
    @GetMapping("/admin/clean/advice")
    public @ResponseBody FileClean cleanAdvice(){
        Integer counts = 0;//清理文件的数量
        String folder = "advice";
        Long size = 0L;
        FileClean fileClean = null;
        try{
            Resource[] resources = resourcePatternResolver.getResources("file:"+uploadpath+"advice/*/*");
            for(Resource resource:resources){
                String url = resource.getURL().toString();
                Integer index = url.lastIndexOf("/upload");
                String uri = url.substring(index);
                Boolean result = processRepository.existsByAttachment(uri);
                if(!result){
                    File file = resource.getFile();
                    counts++;
                    size = size + file.length();
                    file.delete();
                }
            }
            fileClean = new FileClean(size,folder,counts);
            fileCleanRepository.save(fileClean);
        }catch (Exception e){
            e.printStackTrace();
        }
        return fileClean;
    }






}
