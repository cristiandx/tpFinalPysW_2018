import {Component, OnInit} from '@angular/core';
import {Alquiler} from '../../models/alquiler';
import {GaleriaService} from '../../services/galeria.service';
import {Propietario} from '../../models/propietario';
import {Local} from '../../models/local';

@Component({
  selector: 'app-alquiler',
  templateUrl: './alquiler.component.html',
  styleUrls: ['./alquiler.component.css']
})
export class AlquilerComponent implements OnInit {

  submitted = false;
  btnactualizar = false;
  array: Array<Alquiler> = [];
  alquiler: Alquiler = new Alquiler();
  propietarios: Array<Propietario> = [];
  locales: Array<Local> = [];

  constructor(private servicio: GaleriaService) {
    this.cargarLocales();
    this.cargarPropietarios();
  }

  onSubmit() {
    this.submitted = true;
  }

  ngOnInit() {
    this.refreshList();
  }

  public cargarPropietarios() {
    this.servicio.route = 'propietario';
    this.servicio.getAll().subscribe(
      result => {
        this.propietarios = JSON.parse(result.propietarios);
      },
      error => {
        console.log(error);
      }
    );
  }

  public cargarLocales() {
    this.servicio.route = 'local';
    this.servicio.getAll().subscribe(
      result => {
        this.locales = JSON.parse(result.locales);
      },
      error => {
        console.log(error);
      }
    );
  }

  public refreshList() {
    this.servicio.route = 'alquiler';
    this.servicio.getAll().subscribe(
      result => {
        this.array = JSON.parse(result.alquileres);
      },
      error => {
        console.log(error);
      }
    );
  }

  public update() {
    this.servicio.update(this.alquiler).subscribe(
      result => {
        console.log('update correcto');
        this.btnactualizar = false;
        this.refreshList();
      },
      error => console.log('error: ' + error)
    );
  }

  public save() {
    this.servicio.save(this.alquiler).subscribe(
      data => {
        console.log('envio ok');
        console.log('agregado correctamente.');
        this.alquiler = new Alquiler();
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
    this.alquiler = this.array.filter(x => x === objeto).pop();
    this.btnactualizar = true;
  }

  filtrarFecha(fecha) {
    console.log(fecha);
    // const a = this.array.filter(x => {
    //  const f =  x.fechaAlquiler;
    //   console.log(f);
    //   // return f.toDateString().substring(0, 4) === fecha.value.substring(0, 4);
    // }
    // console.log(a);
  }
  setPropietario(form) {
    const selected: Propietario = form.controls['propietario'].value;
    this.alquiler.propietario = selected;
    // this.novedad.usuario = this.usuarios.filter(x => x.id === user.id).pop();
  }
  setLocal(form) {
    const selected: Local = form.controls['local'].value;
    this.alquiler.local = selected;
    // this.novedad.usuario = this.usuarios.filter(x => x.id === user.id).pop();
  }
}
