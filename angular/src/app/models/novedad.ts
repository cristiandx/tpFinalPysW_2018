import { Usuario } from './usuario';

export class Novedad {
    id: number;
    usuario: Usuario;
    texto: string;
    estado: string;

    constructor(user?: Usuario, text?: string, state?: string) {
        this.usuario = user;
        this.texto = text;
        this.estado = state;
    }
}