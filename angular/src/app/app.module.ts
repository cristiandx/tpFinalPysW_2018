import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {FormsModule} from '@angular/forms';
import {HttpModule} from '@angular/http';
import {HttpClientModule} from '@angular/common/http';
import { AppComponent } from './app.component';
import {DataTableModule} from 'angular2-datatable';
import {AuthenticationService} from './services/authentication.service';
import { APP_ROUTING } from './app.routes';
import { HeaderComponent } from './components/header/header.component';
import { LoginComponent } from './components/login/login.component';
import {HomeComponent} from './components/home/home.component';
import { PropietarioComponent } from './components/propietario/propietario.component';
import { LocalComponent } from './components/local/local.component';
import { AlquilerComponent } from './components/alquiler/alquiler.component';
import { UsuarioComponent } from './components/usuario/usuario.component';
import { NovedadComponent } from './components/novedad/novedad.component';
@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    LoginComponent,
    HomeComponent,
    PropietarioComponent,
    LocalComponent,
    AlquilerComponent,
    UsuarioComponent,
    NovedadComponent
  ],
  imports: [
    BrowserModule,
    DataTableModule,
    FormsModule,
    APP_ROUTING,
    HttpClientModule,
    HttpModule
  ],
  providers: [AuthenticationService],
  bootstrap: [AppComponent]
})
export class AppModule { }
