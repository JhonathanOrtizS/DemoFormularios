use evaluacion;

create table asignacion_tramite (
	id_ag int not null,
    user_id int,
    tramite_id int,
    fecha_asignacion date,
    created_at timestamp null,
    updated_at timestamp null,
    estatus varchar(15),
    primary key (id_ag)
);

create table tramite (
	id_tramite int not null,
    nombre varchar(150),
    observaciones text,
    primary key (id_tramite)
);

alter table asignacion_tramite add tramite_cod varchar(15);
alter table asignacion_tramite modify id_ag int auto_increment;
alter table asignacion_tramite change obsernaciones_tramite observaciones_asignacion text;

create table informacion_publica (
	id_ip int not null,
    codigo_tramite varchar(15),
    numero int not null,
    referencia int not null,
    fecha_solicitud date,
    contacto varchar(120),
    direccion varchar(150),
    telefono int(10),
    municipio varchar(25),
    cui int(15),
    detalle_solicitud text,
    estatus varchar(10),
    created_at timestamp null,
    updated_at timestamp null,
    primary key (id_ip)
);