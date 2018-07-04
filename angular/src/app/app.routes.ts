import {RouterModule, Routes} from '@angular/router';
import {LoginComponent} from './components/login/login.component';
import {HomeComponent} from './components/home/home.component';
import {PropietarioComponent} from './components/propietario/propietario.component';
import {LocalComponent} from './components/local/local.component';
import {AlquilerComponent} from './components/alquiler/alquiler.component';
import {UsuarioComponent} from './components/usuario/usuario.component';

const ROUTES: Routes = [
  {path: '', component: HomeComponent},
  {path: 'login', component: LoginComponent},
  {path: 'home', component: HomeComponent},
  {path: 'propietario', component: PropietarioComponent},
  {path: 'local', component: LocalComponent},
  {path: 'alquiler', component: AlquilerComponent},
  {path: 'usuario', component: UsuarioComponent},
  {path: '**', pathMatch: 'full', redirectTo: 'login'}
];

export const APP_ROUTING = RouterModule.forRoot(ROUTES);
