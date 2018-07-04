import { Injectable } from '@angular/core';
import { Http, Headers, Response, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import { Usuario } from '../models/usuario';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  userLoggedIn = false;
  userLogged: Usuario = new Usuario();
  private subject: Subject<Usuario> = new Subject();

  constructor(private http: Http) { }

  login(usuario: string, password: string) {
      return this.http.post('http://localhost/tpFinalPysW_2018/symfony/web/app_dev.php/usuario/authenticate',
       JSON.stringify({ usuario: usuario, password: password }),
      ).map(res => res.json());
  }

  logout() {
      // remove user from local storage to log user out
      localStorage.removeItem('currentUser');
      this.userLogged = new Usuario();
      this.userLoggedIn = false;
      this.subject.next(new Usuario());
  }

  setUserLogged(user: Usuario) {
    this.userLogged = user;
    this.userLoggedIn = true;
    this.subject.next(user);
  }

  getObservable(): Observable<Usuario> {
    return this.subject.asObservable();
  }
}
