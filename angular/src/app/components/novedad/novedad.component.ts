import { Component, OnInit } from '@angular/core';
import { Novedad } from '../../models/novedad';
import { GaleriaService } from '../../services/galeria.service';
import { Usuario } from '../../models/usuario';
import { AuthenticationService } from '../../services/authentication.service';

@Component({
  selector: 'app-novedad',
  templateUrl: './novedad.component.html',
  styleUrls: ['./novedad.component.css']
})
export class NovedadComponent implements OnInit {
  submitted = false;
  btnactualizar = false;
  array: Array<Novedad> = [];
  novedad: Novedad = new Novedad(new Usuario());
  usuarios: Array<Usuario> = [];
  usuario: Usuario = new Usuario();
  constructor(
    private authenticationService: AuthenticationService,
    private servicio: GaleriaService) {

  }

  onSubmit() {
    this.submitted = true;
  }

  ngOnInit() {
    this.getUsuarios();
    this.refreshList();
    this.usuario = this.authenticationService.userLogged;
  }

  public refreshList() {
    this.servicio.route = 'novedad';
    this.servicio.getAll().subscribe(
      result => {
        const temp: Array<Novedad> = JSON.parse(result.novedades);
        if (this.authenticationService.userLogged.perfil !== 'administrador') {
          this.array = temp.filter(u => u.usuario.id === this.authenticationService.userLogged.id);
        } else {
          this.array = temp;
        }
      },
      error => {
        console.log(error);
      }
    );
  }
  public getUsuarios() {
    this.servicio.route = 'usuario';
    this.servicio.getAll().subscribe(
      result => {
        this.usuarios = JSON.parse(result.usuarios);
      },
      error => {
        console.log(error);
      }
    );
  }
  public update() {
    this.novedad.usuario = this.usuario;
    this.servicio.update(this.novedad).subscribe(
      result => {
        console.log('update correcto');
        this.btnactualizar = false;
        // this.novedad = new Novedad(new Usuario(),' ',null);
        this.refreshList();
      },
      error => console.log('error: ' + error)
    );
  }

  public save() {
    this.novedad.usuario = this.usuario;
    console.log(this.novedad);
    this.servicio.save(this.novedad).subscribe(
      data => {
        console.log('envio ok');
        console.log('agregado correctamente.');
        this.novedad = new Novedad(new Usuario(), ' ', null);
        this.btnactualizar = false;
        this.refreshList();
        return true;
      },
      error => {
        console.error('Error saving!');
        console.log(error);
        return false;
      }
    );
  }

  eliminar(objeto: any) {
    this.servicio.delete(objeto).subscribe(
      result => {
        console.log('envio delete');
        this.refreshList();
      },
      error => console.log('error: ' + error)
    );
  }

  elegir(objeto: any) {
    // this.novedad = this.array.filter(x => x === objeto).pop();
    this.novedad = this.array.filter(x => {
      if (x === objeto) {
        x.usuario = objeto.usuario;
        return x;
      }
    }).pop();
    this.btnactualizar = true;
  }
  // setUsuario(form) {
  //   const userSelect: Usuario = form.controls['usuario'].value;
  //   this.novedad.usuario = userSelect;
  //   // this.novedad.usuario = this.usuarios.filter(x => x.id === user.id).pop();
  // }
}
