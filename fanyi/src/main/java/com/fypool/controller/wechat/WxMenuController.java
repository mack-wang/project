package com.fypool.controller.wechat;

import me.chanjar.weixin.common.api.WxConsts;
import me.chanjar.weixin.common.bean.menu.WxMenu;
import me.chanjar.weixin.common.bean.menu.WxMenuButton;
import me.chanjar.weixin.common.exception.WxErrorException;
import me.chanjar.weixin.mp.api.WxMpMenuService;
import me.chanjar.weixin.mp.api.WxMpService;
import me.chanjar.weixin.mp.bean.menu.WxMpGetSelfMenuInfoResult;
import me.chanjar.weixin.mp.bean.menu.WxMpMenu;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.web.bind.annotation.*;

/**
 * <pre>
 *  注意：此contorller 实现WxMpMenuService接口，仅是为了演示如何调用所有菜单相关操作接口，
 *      实际项目中无需这样，根据自己需要添加对应接口即可
 * </pre>
 *
 * @author Binary Wang(https://github.com/binarywang)
 */
@RestController
@RequestMapping("/wechat/menu")
public class WxMenuController implements WxMpMenuService {

    @Autowired
    private WxMpService wxMpService;

    @Value("${domain.url}")
    private String domain;


    /**
     * <pre>
     * 自定义菜单创建接口
     * 详情请见：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141013&token=&lang=zh_CN
     * 如果要创建个性化菜单，请设置matchrule属性
     * 详情请见：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1455782296&token=&lang=zh_CN
     * </pre>
     *
     * @param menu
     * @return 如果是个性化菜单，则返回menuid，否则返回null
     */
    @Override
    @PostMapping("/create")
    public String menuCreate(@RequestBody WxMenu menu) throws WxErrorException {
        return this.wxMpService.getMenuService().menuCreate(menu);
    }

    @GetMapping("/create")
    public String menuCreateSample() throws WxErrorException {
        //菜单：快速查询、翻易大厅、绑定账号
        //以下均无需登入就能访问

        //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxc1414468857f698b&redirect_uri=http%3A%2F%2Fwww.luhuzhuangyuan.com%2Fwechat%2Fpublic%2Flogin&response_type=code&scope=snsapi_userinfo&state=#wechat_redirect
        //无论从哪里进入，都要获取用户的openid,并缓存起来，然后再跳转到对应的正常链接
        WxMenu menu = new WxMenu();
        WxMenuButton button1 = new WxMenuButton();
        button1.setType(WxConsts.BUTTON_VIEW);
        button1.setName("个人中心");
        button1.setUrl(wxMpService.oauth2buildAuthorizationUrl(domain+"/wechat/public/info", WxConsts.OAUTH2_SCOPE_USER_INFO, null));


        //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxc1414468857f698b&redirect_uri=http%3A%2F%2Fwww.luhuzhuangyuan.com%2Fwechat%2Fpublic%2Fmarket&response_type=code&scope=snsapi_userinfo&state=#wechat_redirect
        WxMenuButton button2 = new WxMenuButton();
        button2.setType(WxConsts.BUTTON_VIEW);
        button2.setName("翻易大厅");
        button2.setUrl(wxMpService.oauth2buildAuthorizationUrl(domain+"/wechat/public/market", WxConsts.OAUTH2_SCOPE_USER_INFO, null));

        //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxc1414468857f698b&redirect_uri=http%3A%2F%2Fwww.luhuzhuangyuan.com%2Fwechat%2Fpublic%2FfastQuery&response_type=code&scope=snsapi_userinfo&state=#wechat_redirect
        WxMenuButton button3 = new WxMenuButton();
        button3.setType(WxConsts.BUTTON_VIEW);
        button3.setName("绑定账号");
        button3.setUrl(wxMpService.oauth2buildAuthorizationUrl(domain+"/wechat/public/login", WxConsts.OAUTH2_SCOPE_USER_INFO, null));

        menu.getButtons().add(button1);
        menu.getButtons().add(button2);
        menu.getButtons().add(button3);

        return this.wxMpService.getMenuService().menuCreate(menu);
    }

    @GetMapping("/show")
    public @ResponseBody String menuShow() throws WxErrorException {
        return wxMpService.oauth2buildAuthorizationUrl(domain+"/wechat/public/login", WxConsts.OAUTH2_SCOPE_USER_INFO, null);

    }

    /**
     * <pre>
     * 自定义菜单创建接口
     * 详情请见： https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141013&token=&lang=zh_CN
     * 如果要创建个性化菜单，请设置matchrule属性
     * 详情请见：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1455782296&token=&lang=zh_CN
     * </pre>
     *
     * @param json
     * @return 如果是个性化菜单，则返回menuid，否则返回null
     */
    @Override
    @GetMapping("/create/{json}")
    public String menuCreate(@PathVariable String json) throws WxErrorException {
        return this.wxMpService.getMenuService().menuCreate(json);
    }

    /**
     * <pre>
     * 自定义菜单删除接口
     * 详情请见: https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141015&token=&lang=zh_CN
     * </pre>
     */
    @Override
    @GetMapping("/delete")
    public void menuDelete() throws WxErrorException {
        this.wxMpService.getMenuService().menuDelete();
    }

    /**
     * <pre>
     * 删除个性化菜单接口
     * 详情请见: https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1455782296&token=&lang=zh_CN
     * </pre>
     *
     * @param menuId 个性化菜单的menuid
     */
    @Override
    @GetMapping("/delete/{menuId}")
    public void menuDelete(@PathVariable String menuId) throws WxErrorException {
        this.wxMpService.getMenuService().menuDelete(menuId);
    }

    /**
     * <pre>
     * 自定义菜单查询接口
     * 详情请见： https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141014&token=&lang=zh_CN
     * </pre>
     */
    @Override
    @GetMapping("/get")
    public WxMpMenu menuGet() throws WxErrorException {
        return this.wxMpService.getMenuService().menuGet();
    }

    /**
     * <pre>
     * 测试个性化菜单匹配结果
     * 详情请见: http://mp.weixin.qq.com/wiki/0/c48ccd12b69ae023159b4bfaa7c39c20.html
     * </pre>
     *
     * @param userid 可以是粉丝的OpenID，也可以是粉丝的微信号。
     */
    @Override
    @GetMapping("/menuTryMatch/{userid}")
    public WxMenu menuTryMatch(@PathVariable String userid) throws WxErrorException {
        return this.wxMpService.getMenuService().menuTryMatch(userid);
    }

    /**
     * <pre>
     * 获取自定义菜单配置接口
     * 本接口将会提供公众号当前使用的自定义菜单的配置，如果公众号是通过API调用设置的菜单，则返回菜单的开发配置，而如果公众号是在公众平台官网通过网站功能发布菜单，则本接口返回运营者设置的菜单配置。
     * 请注意：
     * 1、第三方平台开发者可以通过本接口，在旗下公众号将业务授权给你后，立即通过本接口检测公众号的自定义菜单配置，并通过接口再次给公众号设置好自动回复规则，以提升公众号运营者的业务体验。
     * 2、本接口与自定义菜单查询接口的不同之处在于，本接口无论公众号的接口是如何设置的，都能查询到接口，而自定义菜单查询接口则仅能查询到使用API设置的菜单配置。
     * 3、认证/未认证的服务号/订阅号，以及接口测试号，均拥有该接口权限。
     * 4、从第三方平台的公众号登录授权机制上来说，该接口从属于消息与菜单权限集。
     * 5、本接口中返回的图片/语音/视频为临时素材（临时素材每次获取都不同，3天内有效，通过素材管理-获取临时素材接口来获取这些素材），本接口返回的图文消息为永久素材素材（通过素材管理-获取永久素材接口来获取这些素材）。
     *  接口调用请求说明:
     * http请求方式: GET（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=ACCESS_TOKEN
     * </pre>
     */
    @Override
    @GetMapping("/getSelfMenuInfo")
    public WxMpGetSelfMenuInfoResult getSelfMenuInfo() throws WxErrorException {
        return this.wxMpService.getMenuService().getSelfMenuInfo();
    }


}
