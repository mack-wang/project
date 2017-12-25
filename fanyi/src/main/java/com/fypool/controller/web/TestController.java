package com.fypool.controller.web;

import com.fypool.model.*;
import com.fypool.model.Process;
import com.fypool.repository.*;
import com.fypool.sms.sdk.CCPRestSDK;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Controller;
import org.springframework.util.ResourceUtils;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.NoResultException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.io.File;
import java.io.FileNotFoundException;
import java.math.BigDecimal;
import java.text.SimpleDateFormat;
import java.util.*;

@Controller
public class TestController {
    @Autowired
    UserRepository userRepository;

    @Autowired
    SmsRepository smsRepository;

    @Autowired
    TaskRepository taskRepository;

    @Autowired
    private EntityManager entityManager;

    @Autowired
    private CompanyRepository companyRepository;

    @Autowired
    BaseMessageRepository baseMessageRepository;

    @Autowired
    TaskUserRepository taskUserRepository;

    @Autowired
    ProcessRepository processRepository;

    @Autowired
    RoleRepository roleRepository;

    @Autowired
    BillRepository billRepository;

    @Autowired
    TicketRepository ticketRepository;

    @GetMapping("/public/test1")
    public @ResponseBody
    void test() throws FileNotFoundException {
        File file = ResourceUtils.getFile("file:/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/upload/qrcode/201711071255206633.png");
        System.out.println(file.lastModified());
    }

    @PostMapping("/public/upload")
    public @ResponseBody
    String upload(@RequestParam("educationPicture") MultipartFile file) {
        String fileName = file.getOriginalFilename();
        System.out.println(fileName);
        return fileName;
    }

    @GetMapping("/public/session")
    public @ResponseBody
    Boolean session(HttpServletRequest request, HttpSession session) {
        BCryptPasswordEncoder crypt = new BCryptPasswordEncoder();

        return crypt.matches("123456", "$2a$10$NCe9O6gl3eiZKQja.KlzouCWFspgHFlgLNSrWZN0c/2HofabBv2NK");
    }


    @GetMapping("/public/json")
    public @ResponseBody
    Object hellomap() {
        return entityManager.createQuery("select sum(b.variation) from Balance b where b.user = :user and b.accounting.type = 1").setParameter("user", userRepository.findOne(2)).getSingleResult();
    }

    @GetMapping("/public/many")
    public @ResponseBody
    Object deleteMany() {
        return entityManager.createQuery("select sum(price) from VipTask v").getSingleResult();
    }


}
