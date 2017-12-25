import React from 'react';
import { Layout, Menu, Breadcrumb, Icon, Row, Col, Pagination } from 'antd';
import { connect } from 'dva';
import Navigator from 'components/Navigator';
import Article from 'components/Article';
import dateformat from 'dateformat';
import style from './IndexPage.css';

const { SubMenu } = Menu;
const { Content, Sider, Footer } = Layout;

class IndexPage extends React.Component {

  componentWillMount() {
    const { dispatch } = this.props;
    dispatch({ type: 'index/getMenu', payload: { id: 2 } });
    dispatch({ type: 'query/update', payload: { menu: 2 } });
    dispatch({ type: 'index/getArticles' });
  }

  handleClick = ({ item, key, keyPath }) => {
    const { dispatch } = this.props;
    dispatch({ type: 'query/update', payload: { catalogId: key, menu: null } });
    dispatch({ type: 'index/getArticles' });
  };

  makeArticleList = () => {
    const { articles, dispatch } = this.props;
    if (articles === null) return;
    return articles.list.map((item) => {
      return (<Row
        className={style.articleRow}
        onClick={() =>
        dispatch({ type: 'index/getOneArticle', payload: { id: item.id } })}
        key={item.id}
      >
        <Col span={20}>
          <span>{item.top === 0 ? '' : <Icon type="pushpin-o" style={{ color: 'red' }} />}</span>
          <span>{item.recommend === 0 ? '' : <Icon type="star-o" style={{ color: 'red' }} />}</span>
          {item.title}</Col>
        <Col span={4}>{dateformat(item.createdAt, 'yyyy年MM月dd日')}</Col>
      </Row>);
    });
  };

  makeMenu = () => {
    const { menu } = this.props;
    if (menu === null) return;
    return (menu.map((item1) => {
      return (<SubMenu key={item1.value} title={<span><Icon type="book" />{item1.label}</span>}>
        {item1.children.map(item2 => <Menu.Item key={item2.value}>{item2.label}</Menu.Item>)}
      </SubMenu>);
    }));
  };

  render() {
    const { menu, openKeys, selectedKeys, articles, article } = this.props;
    return (
      <Layout style={{ height: '100%' }}>
        <Navigator />
        <Content style={{ padding: '0 50px', backgroundColor: '#EEF0F4' }}>
          <Breadcrumb style={{ margin: '12px 0' }}>
            <Breadcrumb.Item>前端技术</Breadcrumb.Item>
            <Breadcrumb.Item>JavaScript</Breadcrumb.Item>
            <Breadcrumb.Item>ES2015</Breadcrumb.Item>
          </Breadcrumb>
          <Layout style={{ padding: '24px 0', background: '#fff' }}>
            <Sider width={200} style={{ background: '#fff' }}>
              <Menu
                mode="inline"
                style={{ height: '100%' }}
                onClick={this.handleClick}
              >
                { this.makeMenu() }
              </Menu>
            </Sider>
            <Content style={{ padding: '0 24px', minHeight: 700 }} >
              {
                article ?
                  <Article />
                  :
                  <div>
                    {this.makeArticleList()}
                    <Pagination defaultCurrent={1} total={articles ? articles.total : 0} style={{ float: 'right', marginTop: 14 }} />
                  </div>
              }

            </Content>
          </Layout>
        </Content>
        <Footer style={{ textAlign: 'center' }}>
          愚人云端 ©2017 浙ICP备17042562号
        </Footer>
      </Layout>
    );
  }
}

function mapStateToProps(state) {
  return {
    menu: state.index.menu,
    openKeys: state.index.openKeys,
    selectedKeys: state.index.selectedKeys,
    articles: state.index.articles,
    article: state.index.article,
  };
}

export default connect(mapStateToProps)(IndexPage);
