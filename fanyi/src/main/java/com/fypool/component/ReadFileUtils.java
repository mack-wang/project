package com.fypool.component;


import org.apache.commons.io.FileUtils;
import org.apache.pdfbox.io.RandomAccessBuffer;
import org.apache.pdfbox.pdfparser.PDFParser;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.text.PDFTextStripper;
import org.apache.poi.POIXMLDocument;
import org.apache.poi.hslf.extractor.PowerPointExtractor;
import org.apache.poi.hssf.usermodel.HSSFCell;
import org.apache.poi.hssf.usermodel.HSSFRow;
import org.apache.poi.hssf.usermodel.HSSFSheet;
import org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.apache.poi.hwpf.extractor.WordExtractor;
import org.apache.poi.openxml4j.exceptions.OpenXML4JException;
import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.xslf.extractor.XSLFPowerPointExtractor;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.apache.poi.xwpf.extractor.XWPFWordExtractor;
import org.apache.xmlbeans.XmlException;
import org.springframework.stereotype.Component;

import java.io.*;
import java.text.NumberFormat;
import java.util.HashMap;
import java.util.Map;
import java.util.StringTokenizer;

@Component
public class ReadFileUtils {


    /**
     * @param args
     * @throws Exception
     */
    public static void main(String[] args) throws Exception {
        ReadFileUtils rf = new ReadFileUtils();
        Map<String,Integer> detail = new HashMap<>();
//        String s = "";
// s = rf.readTXT("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/test.txt");
// s = rf.readPDF("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/你好.pdf");
// s = rf.readEXCEL("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/hello.xls");
// s = rf.readEXCEL2007("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/你好.xlsx");
// s = rf.readWORD("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/你好.doc");
// s = rf.readWORD2007("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/hello.docx");
// s = rf.readPPT("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/hello.ppt");
// s = rf.readPPT2007("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/hello.pptx");

        //map
// detail = rf.readTXTDetail("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/test.txt");
// detail = rf.readPDFDetail("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/hello.pdf");
// detail = rf.readEXCELDetail("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/hello.xls");
// detail = rf.readEXCEL2007Detail("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/你好.xlsx");
// detail = rf.readWORDDetail("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/你好.doc");
// detail = rf.readWORD2007Detail("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/hello.docx");
// detail = rf.readPPTDetail("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/hello.ppt");
 detail = rf.readPPT2007Detail("/Users/wanglecheng/Web/www/vultr/fanyi/src/main/resources/static/test/hello.pptx");
        System.out.println(detail.get("pages"));
        System.out.println(detail.get("chars"));
        System.out.println(detail.get("words"));
    }


    // 读取ppt
    public String readPPT(String file) throws Exception {
        String returnStr = "";
        try {
            PowerPointExtractor powerPointExtractor = new PowerPointExtractor(new FileInputStream(new File(file)));
            returnStr = powerPointExtractor.getText();
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return returnStr;
    }

    // 读取ppt的详细信息
    public Map<String,Integer> readPPTDetail(String file) throws Exception {
        Map<String,Integer> detail = new HashMap<>();
        try {
            PowerPointExtractor powerPointExtractor = new PowerPointExtractor(new FileInputStream(new File(file)));
            String text = powerPointExtractor.getText();
            detail.put("pages",powerPointExtractor.getDocSummaryInformation().getSlideCount());
            detail.put("chars",countChars(text));
            detail.put("words",countWords(text));
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return detail;
    }



    // 读取pptx
    public String readPPT2007(String file) throws IOException, XmlException, OpenXML4JException {
        return new XSLFPowerPointExtractor(POIXMLDocument.openPackage(file)).getText();
    }

    public Map<String,Integer> readPPT2007Detail(String file) throws IOException, XmlException, OpenXML4JException {
        Map<String,Integer> detail = new HashMap<>();
        XSLFPowerPointExtractor xslfPowerPointExtractor = new XSLFPowerPointExtractor(POIXMLDocument.openPackage(file));
        String text = xslfPowerPointExtractor.getText();
        detail.put("pages",xslfPowerPointExtractor.getDocument().getProperties().getExtendedProperties().getSlides());
        detail.put("chars",countChars(text));
        detail.put("words",countWords(text));
        return detail;
    }


    // 读取xls文件
    public String readEXCEL(String file) throws IOException {
        StringBuilder content = new StringBuilder();
        HSSFWorkbook workbook = new HSSFWorkbook(new FileInputStream(file));// 创建对Excel工作簿文件的引用
        for (int numSheets = 0; numSheets < workbook.getNumberOfSheets(); numSheets++) {
            if (null != workbook.getSheetAt(numSheets)) {
                HSSFSheet aSheet = workbook.getSheetAt(numSheets);// 获得一个sheet
                for (int rowNumOfSheet = 0; rowNumOfSheet <= aSheet
                        .getLastRowNum(); rowNumOfSheet++) {
                    if (null != aSheet.getRow(rowNumOfSheet)) {
                        HSSFRow aRow = aSheet.getRow(rowNumOfSheet); // 获得一个行
                        for (short cellNumOfRow = 0; cellNumOfRow <= aRow
                                .getLastCellNum(); cellNumOfRow++) {
                            if (null != aRow.getCell(cellNumOfRow)) {
                                HSSFCell aCell = aRow.getCell(cellNumOfRow);// 获得列值
                                if (this.convertCell(aCell).length() > 0) {
                                    content.append(this.convertCell(aCell));
                                }
                            }
                            content.append("\n");
                        }
                    }
                }
            }
        }
        return content.toString();
    }

    public Map<String,Integer> readEXCELDetail(String file){
        Map<String,Integer> detail = new HashMap<>();
        try {
            String str = readEXCEL(file);
            detail.put("pages",0);
            detail.put("chars",countChars(str));
            detail.put("words",countWords(str));
        } catch (IOException e) {
            e.printStackTrace();
        }
        return  detail;
    }


    // 读取xlsx文件
    public String readEXCEL2007(String file) throws IOException {
        StringBuilder content = new StringBuilder();
        XSSFWorkbook workbook = new XSSFWorkbook(file);
        for (int numSheets = 0; numSheets < workbook.getNumberOfSheets(); numSheets++) {
            if (null != workbook.getSheetAt(numSheets)) {
                XSSFSheet aSheet = workbook.getSheetAt(numSheets);// 获得一个sheet
                for (int rowNumOfSheet = 0; rowNumOfSheet <= aSheet
                        .getLastRowNum(); rowNumOfSheet++) {
                    if (null != aSheet.getRow(rowNumOfSheet)) {
                        XSSFRow aRow = aSheet.getRow(rowNumOfSheet); // 获得一个行
                        for (short cellNumOfRow = 0; cellNumOfRow <= aRow
                                .getLastCellNum(); cellNumOfRow++) {
                            if (null != aRow.getCell(cellNumOfRow)) {
                                XSSFCell aCell = aRow.getCell(cellNumOfRow);// 获得列值
                                if (this.convertCell(aCell).length() > 0) {
                                    content.append(this.convertCell(aCell));
                                }
                            }
                            content.append("\n");
                        }
                    }
                }
            }
        }
        return content.toString();
    }

    public Map<String,Integer> readEXCEL2007Detail(String file){
        Map<String,Integer> detail = new HashMap<>();
        try {
            String str = readEXCEL2007(file);
            detail.put("pages",0);
            detail.put("chars",countChars(str));
            detail.put("words",countWords(str));
        } catch (IOException e) {
            e.printStackTrace();
        }
        return  detail;
    }


    private String convertCell(Cell cell) {
        NumberFormat formater = NumberFormat.getInstance();
        formater.setGroupingUsed(false);
        String cellValue = "";
        if (cell == null) {
            return cellValue;
        }


        switch (cell.getCellType()) {
            case HSSFCell.CELL_TYPE_NUMERIC:
                cellValue = formater.format(cell.getNumericCellValue());
                break;
            case HSSFCell.CELL_TYPE_STRING:
                cellValue = cell.getStringCellValue();
                break;
            case HSSFCell.CELL_TYPE_BLANK:
                cellValue = cell.getStringCellValue();
                break;
            case HSSFCell.CELL_TYPE_BOOLEAN:
                cellValue = Boolean.valueOf(cell.getBooleanCellValue()).toString();
                break;
            case HSSFCell.CELL_TYPE_ERROR:
                cellValue = String.valueOf(cell.getErrorCellValue());
                break;
            default:
                cellValue = "";
        }
        return cellValue.trim();
    }


    // 读取pdf文件
    public String readPDF(String file) throws IOException {
        String result = null;
        FileInputStream is = null;
        PDDocument document = null;
        try {
            is = new FileInputStream(file);
            PDFParser parser = new PDFParser(new RandomAccessBuffer(is));
            parser.parse();
            document = parser.getPDDocument();
            PDFTextStripper stripper = new PDFTextStripper();
            result = stripper.getText(document);
        } finally {
            if (is != null) {
                is.close();
            }
            if (document != null) {
                document.close();
            }
        }
        return result;
    }

    public Map<String,Integer> readPDFDetail(String file) throws IOException {
        Map<String,Integer> detail = new HashMap<>();
        String result = null;
        FileInputStream is = null;
        PDDocument document = null;
        try {
            is = new FileInputStream(file);
            PDFParser parser = new PDFParser(new RandomAccessBuffer(is));
            parser.parse();
            document = parser.getPDDocument();
            PDFTextStripper stripper = new PDFTextStripper();
            result = stripper.getText(document);

            detail.put("pages",document.getNumberOfPages());
            detail.put("chars",countChars(result));
            detail.put("words",countWords(result));

        } finally {
            if (is != null) {
                is.close();
            }
            if (document != null) {
                document.close();
            }
        }
        return detail;
    }


    // 读取doc文件
    public String readWORD(String file) throws Exception {
        String returnStr = "";
        try {
            WordExtractor wordExtractor = new WordExtractor(new FileInputStream(new File(file)));
            returnStr = wordExtractor.getText();
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return returnStr;
    }

    public Map<String,Integer> readWORDDetail(String file) throws Exception {
        Map<String,Integer> detail = new HashMap<>();
        try {
            WordExtractor wordExtractor = new WordExtractor(new FileInputStream(new File(file)));
            String text = wordExtractor.getText();
            detail.put("pages",wordExtractor.getDocSummaryInformation().getSlideCount());
            detail.put("chars",countChars(text));
            detail.put("words",countWords(text));
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return detail;
    }



    // 读取docx文件
    public String readWORD2007(String file) throws Exception {
        return new XWPFWordExtractor(POIXMLDocument.openPackage(file)).getText();
    }

    public Map<String,Integer> readWORD2007Detail(String file) throws IOException, XmlException, OpenXML4JException {
        Map<String,Integer> detail = new HashMap<>();
        XWPFWordExtractor xwpfWordExtractor = new XWPFWordExtractor(POIXMLDocument.openPackage(file));
        String text = xwpfWordExtractor.getText();
        detail.put("pages",xwpfWordExtractor.getDocument().getProperties().getExtendedProperties().getPages());
        detail.put("chars",countChars(text));
        detail.put("words",countWords(text));
        return detail;
    }

    // 读取txt文件
    public String readTXT(String file) throws IOException {
        String encoding = ReadFileUtils.get_charset(new File(file));
        if (encoding.equalsIgnoreCase("GBK")) {
            return FileUtils.readFileToString(new File(file), "gbk");
        } else {
            return FileUtils.readFileToString(new File(file), "utf8");
        }
    }


    public Map<String,Integer> readTXTDetail(String file){
        Map<String,Integer> detail = new HashMap<>();
        try {
            String str = readTXT(file);
            detail.put("pages",0);
            detail.put("chars",countChars(str));
            detail.put("words",countWords(str));
        } catch (IOException e) {
            e.printStackTrace();
        }
        return  detail;
    }


    private static String get_charset(File file) throws IOException {
        String charset = "GBK";
        byte[] first3Bytes = new byte[3];
        BufferedInputStream bis = null;
        try {
            boolean checked = false;
            bis = new BufferedInputStream(new FileInputStream(file));
            bis.mark(0);
            int read = bis.read(first3Bytes, 0, 3);
            if (read == -1)
                return charset;
            if (first3Bytes[0] == (byte) 0xFF && first3Bytes[1] == (byte) 0xFE) {
                charset = "UTF-16LE";
                checked = true;
            } else if (first3Bytes[0] == (byte) 0xFE
                    && first3Bytes[1] == (byte) 0xFF) {
                charset = "UTF-16BE";
                checked = true;
            } else if (first3Bytes[0] == (byte) 0xEF
                    && first3Bytes[1] == (byte) 0xBB
                    && first3Bytes[2] == (byte) 0xBF) {
                charset = "UTF-8";
                checked = true;
            }
            bis.reset();
            if (!checked) {
// int len = 0;
                int loc = 0;


                while ((read = bis.read()) != -1) {
                    loc++;
                    if (read >= 0xF0)
                        break;
                    if (0x80 <= read && read <= 0xBF) // 单独出现BF以下的，也算是GBK
                        break;
                    if (0xC0 <= read && read <= 0xDF) {
                        read = bis.read();
                        if (0x80 <= read && read <= 0xBF) // 双字节 (0xC0 - 0xDF)
// (0x80
// - 0xBF),也可能在GB编码内
                            continue;
                        else
                            break;
                    } else if (0xE0 <= read && read <= 0xEF) {// 也有可能出错，但是几率较小
                        read = bis.read();
                        if (0x80 <= read && read <= 0xBF) {
                            read = bis.read();
                            if (0x80 <= read && read <= 0xBF) {
                                charset = "UTF-8";
                                break;
                            } else
                                break;
                        } else
                            break;
                    }
                }
// System.out.println( loc + " " + Integer.toHexString( read )
// );
            }
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if (bis != null) {
                bis.close();
            }
        }
        return charset;
    }

    public Integer countChars(String str){
        String newStr = str.replaceAll( "[\\pP+~$`^=|<>～｀＄＾＋＝｜＜＞￥×]" , "");
        Integer chars = 0;
        for(int i=0;i<newStr.length();i++){
            if(newStr.charAt(i)!=' ' && newStr.charAt(i)!='\n') chars ++;
        }
        return chars;
    }

    public Integer countWords(String str){
        Integer words = 0;
        words += new StringTokenizer(str, " ,;:.").countTokens();
        return words-1;//有bug，即使是空文件也有1个字符
    }

}
