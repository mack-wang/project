import React from 'react';
import { Layout } from 'antd';
import { connect } from 'dva';
import Navigator from 'components/Navigator';
import HomeSider from 'components/HomeSider';
import { withRouter } from 'dva/router';


class HomeLayout extends React.Component {
  state = {
    collapsed: false,
    mode: 'inline',
  };

  componentWillMount() {
    // 因为继承了Auth所以自然就拥有了token,username,isAuth这三个props
    const { location } = this.props;
    this.props.dispatch({ type: 'home/login', payload: { location } });
  }

  render() {
    const { children } = this.props;
    return (
      <Layout style={{ height: '100%' }}>
        <Navigator />
        <Layout>
          <HomeSider />
          { children }
        </Layout>
      </Layout>

    );
  }
}

const mapStateToProps = () => ({
});

  // 返回的是一个经过AdminLayout包装的组件
export default withRouter(connect(mapStateToProps)(HomeLayout));

