import { Component, OnInit } from '@angular/core';
import { GaleriaService } from '../../services/galeria.service';
import { Local } from '../../models/local';

@Component({
  selector: 'app-local',
  templateUrl: './local.component.html',
  styleUrls: ['./local.component.css']
})
export class LocalComponent implements OnInit {
  submitted = false;
  btnactualizar = false;
  array: Array<Local> = [];
  local: Local = new Local(0, true, 0, '', false);

  constructor(private servicio: GaleriaService) {
    this.servicio.route = 'local';
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
        this.array = JSON.parse(result.locales);
      },
      error => {
        console.log(error);
      }
    );
  }

  public update() {
    this.servicio.update(this.local).subscribe(
      result => {
        console.log('update correcto');
        this.local = new Local(0, true, 0, '', false);
        this.btnactualizar = false;
        this.refreshList();
      },
      error => console.log('error: ' + error)
    );
  }

  public save() {
    this.servicio.save(this.local).subscribe(
      data => {
        console.log('envio ok');
        console.log('agregado correctamente.');
        this.local = new Local(0, true, 0, '', false);
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
    this.local = this.array.filter(x => x === objeto).pop();
    this.btnactualizar = true;
  }
}
