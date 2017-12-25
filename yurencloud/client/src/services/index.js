import request from 'utils/request';
import config from 'utils/config';
import qs from 'qs';

export function getMenu(param) {
  return request(`${config.api.getCatalog}/nav/${param.id}`);
}

export function getArticles(param) {
  return request(`${config.api.publicArticles}?${qs.stringify(param)}`, {
    method: 'GET',
  }, true);
}
