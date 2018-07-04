export class Local {
    id: number;
    superficie: number;
    habilitado: boolean;
    costomes: number;
    pathimagen: string;
    alquilado: boolean;

    constructor(sup?: number, habilitado?: boolean, costo?: number, path?: string, alquilado?: boolean) {
        this.superficie = sup;
        this.habilitado = habilitado;
        this.costomes = costo;
        this.pathimagen = path;
        this.alquilado = alquilado;
    }
}