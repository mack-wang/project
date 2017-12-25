import React from 'react';
import { connect } from 'dva';
import { Row, Col, Icon } from 'antd';
import Back from 'components/Back';
import style from './Article.css';

class Article extends React.Component {
  render() {
    const { article, dispatch } = this.props;
    return (
      <div>
        <Row>
          <Col><a onClick={() => dispatch({ type: 'index/update', payload: { article: null } })}><Icon type="left" />返回</a></Col>
          <Col className={style.wrap}>
            <div className={style.header}>{article.title}</div>
            <div className={style.sub}><Icon type="like-o" />{article.good} <Icon type="eye-o" />{article.view}</div>
          </Col>
          <Col>
            <div dangerouslySetInnerHTML={{ __html: article.content }} />
          </Col>
        </Row>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  article: state.index.article,
});

export default connect(mapStateToProps)(Article);
