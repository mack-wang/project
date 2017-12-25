package com.fypool.controller.admin;

import com.fypool.component.HelperController;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;

@Controller
public class AdminUploadController {

    @Autowired
    HelperController helper;

    @PostMapping("/admin/upload/api")
    public @ResponseBody
    String uploadApi(
            @RequestParam("file") MultipartFile file,
            @RequestParam("folder") String folder
    ) {
        return helper.uploadFile(file, folder);
    }

}
