import React from 'react';
import HomeLayout from 'components/HomeLayout';
import { Layout, Breadcrumb, Upload, Button, Icon } from 'antd';

const { Content } = Layout;

// export default function Home(props) {
//   return (
//     <HomeLayout {...props}>
//       <Layout style={{ padding: '0 24px 24px' }}>
//         <Breadcrumb style={{ margin: '12px 0' }}>
//           <Breadcrumb.Item>个人中心</Breadcrumb.Item>
//           <Breadcrumb.Item>我的信息</Breadcrumb.Item>
//         </Breadcrumb>
//         <Content style={{ background: '#fff', padding: 24, margin: 0 }}>
//           Home
//         </Content>
//       </Layout>
//     </HomeLayout>
//   );
// }
//

const fileList = [{
  uid: -1,
  name: 'xxx.png',
  status: 'done',
  url: 'https://zos.alipayobjects.com/rmsportal/jkjgkEfvpUPVyRjUImniVslZfWPnJuuZ.png',
  thumbUrl: 'https://zos.alipayobjects.com/rmsportal/jkjgkEfvpUPVyRjUImniVslZfWPnJuuZ.png',
}, {
  uid: -2,
  name: 'yyy.png',
  status: 'done',
  url: 'https://zos.alipayobjects.com/rmsportal/jkjgkEfvpUPVyRjUImniVslZfWPnJuuZ.png',
  thumbUrl: 'https://zos.alipayobjects.com/rmsportal/jkjgkEfvpUPVyRjUImniVslZfWPnJuuZ.png',
}];


export default function Home() {
  const props = {
    action: '//jsonplaceholder.typicode.com/posts/',
    listType: 'picture',
    defaultFileList: [...fileList],
  };

  const props2 = {
    action: '//jsonplaceholder.typicode.com/posts/',
    listType: 'picture',
    defaultFileList: [...fileList],
    className: 'upload-list-inline',
  };

  return (<div>
    <Upload {...props}>
      <Button>
        <Icon type="upload" /> upload
      </Button>
    </Upload>
    <br />
    <br />
    <Upload {...props2}>
      <Button>
        <Icon type="upload" /> upload
      </Button>
    </Upload>
  </div>);
}
