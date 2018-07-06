import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
  title = 'PySW - 2018';
  activar = false;
  isAdmin = false;
  isAdministrativo = false;
  isPropietario = false;

  constructor(
    private router: Router,
    private servicio: AuthenticationService
  ) { }

  ngOnInit() {
    this.actualizar();
  }

  logout() {
    this.servicio.logout();
    this.isAdmin = this.isAdministrativo = this.isPropietario = false;
    this.router.navigate(['login']);
  }

  public actualizar() {
    this.servicio.getObservable().subscribe(
      result => {
        if (this.servicio.userLoggedIn !== null) {
          const perfil = result.perfil;
          if (perfil === 'administrador') {
            this.isAdmin = true;
          }
          if (perfil === 'propietario') {
            this.isPropietario = true;
          }
          if (perfil === 'administrativo') {
            this.isAdministrativo = true;
          }
        }
      }
    );
  }
}
