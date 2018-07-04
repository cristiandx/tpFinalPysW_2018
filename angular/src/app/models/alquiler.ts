import { Propietario } from './propietario';
import { Local } from './local';

export class Alquiler {
    id: number;
    propietario: Propietario;
    local: Local;
    plazomes: number;
    costoalquiler: number;
    fechaAlquiler: Date;

    constructor(
        propietario?: Propietario,
        local?: Local,
        plazomes?: number,
        costoalquiler?: number,
        fechaAlquiler?: Date,
    ) {
        this.propietario = propietario;
        this.local = local;
        this.plazomes = plazomes;
        this.costoalquiler = costoalquiler;
        this.fechaAlquiler = fechaAlquiler;
    }
}
