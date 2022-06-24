CREATE TABLE IF NOT EXISTS public.users
(
    numuser integer NOT NULL DEFAULT nextval('users_iduser_seq'::regclass),
    prenom text COLLATE pg_catalog."default" NOT NULL,
    nom text COLLATE pg_catalog."default" NOT NULL,
    email text COLLATE pg_catalog."default",
    cni text COLLATE pg_catalog."default" NOT NULL,
    username text COLLATE pg_catalog."default" NOT NULL,
    password text COLLATE pg_catalog."default" NOT NULL,
    idtype integer NOT NULL,
    idpost integer NOT NULL,
    partager boolean NOT NULL,
    modifier boolean NOT NULL,
    supprimer boolean NOT NULL,
    modifierdesc boolean NOT NULL,
    voirlayernonpartager boolean,
    CONSTRAINT users_pkey PRIMARY KEY (numuser),
    CONSTRAINT users_idpost_fkey FOREIGN KEY (idpost)
        REFERENCES public.post_travail (idpost) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.users
    OWNER to postgres;



    CREATE TABLE IF NOT EXISTS public.typeuser
(
    idtype integer NOT NULL DEFAULT nextval('typeuser_idtype_seq'::regclass),
    type text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT typeuser_pkey PRIMARY KEY (idtype)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.typeuser
    OWNER to postgres;




    CREATE TABLE IF NOT EXISTS public.post_travail
(
    idpost integer NOT NULL DEFAULT nextval('"Post-travail_idpost_seq"'::regclass),
    postravail text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT "Post-travail_pkey" PRIMARY KEY (idpost)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.post_travail
    OWNER to postgres;




    CREATE TABLE IF NOT EXISTS public.layers
(
    idlayer integer NOT NULL DEFAULT nextval('layers_idlayer_seq'::regclass),
    layername text COLLATE pg_catalog."default" NOT NULL,
    datecreer timestamp with time zone,
    numuser integer,
    layerpartager boolean,
    description text COLLATE pg_catalog."default",
    CONSTRAINT layers_pkey PRIMARY KEY (idlayer)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.layers
    OWNER to postgres;




    CREATE DATABASE "SIGMarrakech-safi"
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'English_United States.1252'
    LC_CTYPE = 'English_United States.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;