module.exports = {
  name: 'AntD Admin',
  prefix: 'antdAdmin',
  footerText: 'Ant Design Admin  © 2017 zuiidea',
  logo: '/logo.png',
  iconFontCSS: '/iconfont.css',
  iconFontJS: '/iconfont.js',
  api: {
    userRegister: '/api/auth/register',
    userLogin: '/api/auth',
    userLogout: '/api/user/logout',
    userProfile: '/api/userInfo',
    checkUsername: '/api/public/check/username',
    // 文件上传
    uploadArticleImage: '/api/upload/article/image',
    // 获取文章目录
    getCatalog: '/api/public/catalog',
    catalogCascader: '/api/public/catalog/cascader',
    // 加s则获取多个，不加s则是获取单个
    articles: '/api/articles',
    publicArticles: '/api/public/articles',
    article: '/api/article',
    catalog: '/api/catalog',
    createArticle: '/api/article',
    users: '/api/users',
    posts: '/api/posts',
    user: '/api/user/:id',
    dashboard: '/api/home',
    menus: '/api/menus',
    weather: '/api/weather',
    v1test: '/api/test',
    v2test: '/api/test',
  },
};
