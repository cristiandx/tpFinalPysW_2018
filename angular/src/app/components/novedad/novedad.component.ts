import { Component, OnInit } from '@angular/core';
import { Novedad } from '../../models/novedad';
import { GaleriaService } from '../../services/galeria.service';
import { Usuario } from '../../models/usuario';

@Component({
  selector: 'app-novedad',
  templateUrl: './novedad.component.html',
  styleUrls: ['./novedad.component.css']
})
export class NovedadComponent implements OnInit {
  submitted = false;
  btnactualizar = false;
  array: Array<Novedad> = [];
  novedad: Novedad = new Novedad();
  usuarios: Array<Usuario> = [];

  constructor(private servicio: GaleriaService ) {

   }

  onSubmit() {
    this.submitted = true;
  }

  ngOnInit() {
    this.getUsuarios();
    this.refreshList();
  }

public refreshList() {
  this.servicio.route = 'novedad';
    this.servicio.getAll().subscribe(
      result => {
        this.array = JSON.parse(result.novedades);
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
    this.servicio.update(this.novedad).subscribe(
      result => {
        console.log('update correcto');
        this.btnactualizar = false;
        this.novedad = new Novedad();
        this.refreshList();
      },
      error => console.log('error: ' + error)
    );
  }

  public save() {
    console.log(this.novedad);
    this.servicio.save(this.novedad).subscribe(
      data => {
        console.log('envio ok');
        console.log('agregado correctamente.');
        this.novedad = new Novedad();
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
    this.novedad = this.array.filter(x => {
        if (x === objeto) {
          x.usuario = objeto.usuario;
          return x;
        }
      }).pop();
    this.btnactualizar = true;
  }
}
