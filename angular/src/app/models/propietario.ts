export class Propietario {
    id: number;
    apellido: string;
    nombres: string;
    dni: number;
    email: string;
    telefono: string;

    constructor(apellido?: string, nombres?: string, dni?: number, email?: string, tel?: string) {
        this.apellido = apellido;
        this.nombres = nombres;
        this.dni = dni;
        this.email = email;
        this.telefono = tel;
    }
}
