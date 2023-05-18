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

alter table asignacion_tramite add obsernaciones_tramite text;
alter table asignacion_tramite modify id_ag int auto_increment;
alter table tramite change nombre nombre_tramite varchar(150);