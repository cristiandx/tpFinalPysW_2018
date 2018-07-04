import {Injectable} from '@angular/core';
import {Http, Response, Headers, RequestOptions} from '@angular/http';
import 'rxjs/add/operator/map';

@Injectable({
  providedIn: 'root'
})
export class GaleriaService {

  port = '';
  route = '';

  constructor(private _http: Http) {
  }

  getAll() {
    return this._http.get('http://localhost' + this.port + '/tpFinalPysW_2018/symfony/web/app_dev.php/' + this.route + '/')
      .map(res => res.json());
  }

  save(data: any) {
    const headers = new Headers({'Content-Type': 'application/json'});
    const options = new RequestOptions({headers: headers});
    const body = JSON.stringify(data);
    console.log('entro service create');
    return this._http.post('http://localhost' + this.port + '/tpFinalPysW_2018/symfony/web/app_dev.php/' + this.route + '/new', body, options)
      .map((res: Response) => res.json());
  }

  update(data: any) {
    const headers = new Headers({'Content-Type': 'application/json'});
    const options = new RequestOptions({headers: headers});
    const body = JSON.stringify(data);
    // envio en el body el mensaje transformado en un JSON
    return this._http.post('http://localhost' +
     this.port + '/tpFinalPysW_2018/symfony/web/app_dev.php/' + this.route + '/' + data.id + '/edit', body, options)
      .map((res: Response) => res.json());
  }

  delete(data: any) {
    // utilizo el metodo delete de http que es el configurado en el deleteAction de Symfony
    return this._http.delete(('http://localhost' + this.port + '/tpFinalPysW_2018/symfony/web/app_dev.php/' + this.route + '/' + data.id))
      .map((res: Response) => res.json());
  }
}
