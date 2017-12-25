import React from 'react';
import { Layout, Menu, Icon } from 'antd';
import { connect } from 'dva';
import { Link } from 'dva/router';
import PropTypes from 'prop-types';

const { Sider } = Layout;
const SubMenu = Menu.SubMenu;


class HomeSider extends React.Component {

  handleOnClick = ({ item, key, keyPath }) => {
    // key = "catalog" keyPath = ["catalog二级", "article一级"]
    const subs = {
      article: '文章',
      comment: '评论',
    };
    const state = {
      select: key,
      open: keyPath[1],
      sub: subs[keyPath[1]],
      item: item.props.children,
    };
    const store = this.context.store;
    store.dispatch({ type: 'adminSider/select', payload: state });
  };

  render() {
    const { select, open } = this.props;
    return (
      <Sider width={200} style={{ background: '#fff', backgroundColor: '#EEF0F4' }}>
        <Menu
          mode="inline"
          defaultSelectedKeys={[select]}
          defaultOpenKeys={[open]}
          style={{ height: '100%' }}
          onClick={this.handleOnClick}
        >
          <SubMenu key="article" title={<span><Icon type="user" />文章</span>}>
            <Menu.Item key="create"><Link to="/admin/article/create">添加文章</Link></Menu.Item>
            <Menu.Item key="list"><Link to="/admin/article">文章列表</Link></Menu.Item>
            <Menu.Item key="catalog">编辑目录</Menu.Item>
          </SubMenu>
          <SubMenu key="sub2" title={<span><Icon type="laptop" />subnav 2</span>}>
            <Menu.Item key="5">option5</Menu.Item>
            <Menu.Item key="6">option6</Menu.Item>
            <Menu.Item key="7">option7</Menu.Item>
            <Menu.Item key="8">option8</Menu.Item>
          </SubMenu>
          <SubMenu key="sub3" title={<span><Icon type="notification" />subnav 3</span>}>
            <Menu.Item key="9">option9</Menu.Item>
            <Menu.Item key="10">option10</Menu.Item>
            <Menu.Item key="11">option11</Menu.Item>
            <Menu.Item key="12">option12</Menu.Item>
          </SubMenu>
        </Menu>
      </Sider>
    );
  }
}

HomeSider.contextTypes = {
  store: PropTypes.object.isRequired,
};

const mapStateToProps = state => ({
  select: state.adminSider.select,
  open: state.adminSider.open,
  sub: state.adminSider.sub,
  item: state.adminSider.item,
});

// 返回的是一个经过Auth包装的组件，这个组件自带token、username,isAuth
export default connect(mapStateToProps)(HomeSider);
