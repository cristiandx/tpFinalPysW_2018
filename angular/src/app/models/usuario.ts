export class Usuario {
    id: number;
    email: string;
    usuario: string;
    password: string;
    activo: boolean;
    perfil: string;
    constructor(email?: string, username?: string, password?: string, activo?: boolean, perfil?: string) {
        this.email = email;
        this.usuario = username;
        this.password = password;
        this.activo = activo;
        this.perfil = perfil;
    }
}
