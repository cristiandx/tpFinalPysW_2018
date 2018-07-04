import {Component, OnInit} from '@angular/core';
import {Usuario} from '../../models/usuario';
import {GaleriaService} from '../../services/galeria.service';
import { AuthenticationService } from '../../services/authentication.service';

@Component({
  selector: 'app-usuario',
  templateUrl: './usuario.component.html',
  styleUrls: ['./usuario.component.css']
})
export class UsuarioComponent implements OnInit {
  usuario: Usuario = new Usuario();
  array: Array<Usuario> = [];
  submitted = false;
  btnactualizar = false;
  usersTemp: Array<Usuario> = [];
  userValid = false;

  constructor(private servicio: GaleriaService ) {
    this.servicio.route = 'usuario';
  }

  onSubmit() {
    this.submitted = true;
  }

  ngOnInit() {
    this.refreshList();
  }

public refreshList() {
    this.servicio.getAll().subscribe(
      result => {
        this.array = JSON.parse(result.usuarios);
      },
      error => {
        console.log(error);
      }
    );
  }

  public update() {
    this.servicio.update(this.usuario).subscribe(
      result => {
        console.log('update correcto');
        this.usuario = new Usuario();
        this.btnactualizar = false;
        this.refreshList();
      },
      error => console.log('error: ' + error)
    );
  }

  public save() {
    this.servicio.save(this.usuario).subscribe(
      data => {
        console.log('envio ok');
        console.log('agregado correctamente.');
        this.usuario = new Usuario();
        this.refreshList();
        this.btnactualizar = false;
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
    this.usuario = this.array.filter(x => x === objeto).pop();
    this.btnactualizar = true;
  }
}
