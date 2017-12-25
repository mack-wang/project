import { getMenu, getArticles } from 'services/index';
import { getOne } from 'services/article';

export default {
  namespace: 'index',
  state: {
    menu: null,
    articles: null,
  },
  reducers: {
    update(state, { payload }) {
      return {
        ...state,
        ...payload,
      };
    },
  },
  effects: {
    // 获取首页目录
    *getMenu({ payload }, { call, put }) {
      const { data } = yield call(getMenu, payload);
      const menu = makeMenu(data);
      yield put({ type: 'update',
        payload: {
          menu,
          openKeys: [`${menu[0].value}`],
          selectedKeys: [`${menu[0].children[0].value}`],
      } });
    },
    // 获取当前菜单目录的，第一个目录的所有文章
    *getArticles({ payload }, { call, put, select }) {
      const query = yield select(state => state.query);
      const { data } = yield call(getArticles, query);
      console.log(data);
      yield put({ type: 'update', payload: { articles: data } });
    },
    // 获取选中的目录的所有文章
    *getArticlesByCatalogId({ payload }, { call, put }) {
      const { data } = yield call(getArticles, payload);
      yield put({ type: 'update', payload: { articles: data } });
    },

    // 获取指定文章
    *getOneArticle({ payload }, { call, put }) {
      const { data } = yield call(getOne, payload);
      yield put({ type: 'update', payload: { article: data } });
    },
  },
  subscriptions: {},
};


function makeMenu(data) {
  const arr = [];
  data.map((item) => {
    // 构造一级菜单
    if (item.level === 1) {
      const obj = {
        value: item.id,
        label: item.name,
        children: [],
      };
      data.map((item2) => {
        // 构造二级菜单
        if (item2.level === 2 && obj.value === item2.pid) {
          const obj2 = {
            value: item2.id,
            label: item2.name,
          };
          obj.children.push(obj2);
        }
      });
      arr.push(obj);
    }
  });
  return arr;
}
