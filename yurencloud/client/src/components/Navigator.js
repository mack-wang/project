import React from 'react';
import { Layout, Menu } from 'antd';
import { Link, routerRedux } from 'dva/router';
import { connect } from 'dva';
import img from 'assets/yurencloud.png';

const { Header } = Layout;

class Navigator extends React.Component {

  componentWillMount() {
    const { dispatch } = this.props;
    dispatch({ type: 'catalog/cascaderMenu' });
  }

  handleClick = ({ item, key, keyPath }) => {
    const { dispatch } = this.props;
    dispatch({ type: 'index/getMenu', payload: { id: key } });
  };

  loginHome=() => {
    this.props.dispatch({ type: 'home/login', payload: { pathname: '/login' } });
  };

  render() {
    const { isAuth, username, catalogMenu, dispatch } = this.props;
    return (
      <Header className="header">
        <div className="logo" />
        <Menu
          theme="dark"
          mode="horizontal"
          defaultSelectedKeys={['2']}
          style={{ lineHeight: '64px' }}
          onClick={this.handleClick}
        >
          <Menu.Item key="index"><Link to="/"><img src={img} alt="" style={{ width: 40, height: 30 }} /></Link></Menu.Item>
          <Menu.Item key="index1" style={{ fontSize: 16 }}><Link to="/">愚人云端</Link></Menu.Item>
          { catalogMenu.map(item => <Menu.Item key={item.value}>{item.label}</Menu.Item>)}
          <Menu.Item key="7">博客作者</Menu.Item>
          {
            isAuth ?
            [
              <Menu.Item key="home" style={{ float: 'right' }}><a onClick={this.loginHome}>个人中心</a></Menu.Item>,
              <Menu.Item key="home1" style={{ float: 'right' }}><a onClick={this.loginHome}>{username}</a></Menu.Item>,
              <Menu.Item key="logout" style={{ float: 'right' }}><a onClick={() => dispatch({ type: 'auth/logout' })}>退出</a></Menu.Item>,
            ].map(item => item) :
            [
              <Menu.Item key="8" style={{ float: 'right' }}><Link to="/register">注册</Link></Menu.Item>,
              <Menu.Item key="9" style={{ float: 'right' }}><Link to="/login">登入</Link></Menu.Item>,
            ].map(item => item)
          }
        </Menu>
      </Header>
    );
  }

}

const mapStateToProps = state => ({
  token: state.auth.token,
  username: state.auth.username,
  isAuth: state.auth.isAuth,
  authority: state.auth.authority,
  catalogMenu: state.catalog.catalogMenu,
});

// 返回的是一个经过Auth包装的组件，这个组件自带token、username,isAuth
export default connect(mapStateToProps)(Navigator);
