package com.fypool;

import java.math.BigDecimal;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import com.fypool.controller.pay.AlipayController;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class TestMain{

    private static final Logger logger = LoggerFactory.getLogger(TestMain.class);

    public static void main(String[] args) {
        Long a = 10L;
        Long b = 2L;
        Long c = 0L;
        c+=b;
        System.out.println(c);
    }


}
