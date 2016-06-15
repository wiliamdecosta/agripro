--
-- EnterpriseDB database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog, sys;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: app_menu; Type: TABLE; Schema: public; Owner: optima; Tablespace: 
--

CREATE TABLE app_menu (
    menu_id integer NOT NULL,
    menu_parent integer,
    menu_name character varying(50),
    menu_icon character varying(50),
    menu_desc character varying(100),
    menu_link character varying(50),
    file_name character varying(128),
    listing_no integer
);


ALTER TABLE public.app_menu OWNER TO optima;

--
-- Name: app_menu_groups; Type: TABLE; Schema: public; Owner: optima; Tablespace: 
--

CREATE TABLE app_menu_groups (
    app_menu_group_id integer NOT NULL,
    menu_id numeric(10,0) NOT NULL,
    group_id numeric(10,0) NOT NULL,
    description character varying(32)
);


ALTER TABLE public.app_menu_groups OWNER TO optima;

--
-- Name: app_menu_groups_app_menu_group_id_seq; Type: SEQUENCE; Schema: public; Owner: optima
--

CREATE SEQUENCE app_menu_groups_app_menu_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.app_menu_groups_app_menu_group_id_seq OWNER TO optima;

--
-- Name: app_menu_groups_app_menu_group_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: optima
--

ALTER SEQUENCE app_menu_groups_app_menu_group_id_seq OWNED BY app_menu_groups.app_menu_group_id;


--
-- Name: app_menu_groups_app_menu_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: optima
--

SELECT pg_catalog.setval('app_menu_groups_app_menu_group_id_seq', 26, true);


--
-- Name: app_menu_menu_id_seq; Type: SEQUENCE; Schema: public; Owner: optima
--

CREATE SEQUENCE app_menu_menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.app_menu_menu_id_seq OWNER TO optima;

--
-- Name: app_menu_menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: optima
--

ALTER SEQUENCE app_menu_menu_id_seq OWNED BY app_menu.menu_id;


--
-- Name: app_menu_menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: optima
--

SELECT pg_catalog.setval('app_menu_menu_id_seq', 14, true);


--
-- Name: detail_packaging; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE detail_packaging (
    dp_id integer NOT NULL,
    smd_id integer,
    pkg_id integer,
    dp_qty double precision,
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.detail_packaging OWNER TO agripro;

--
-- Name: detail_packaging_dp_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE detail_packaging_dp_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detail_packaging_dp_id_seq OWNER TO agripro;

--
-- Name: detail_packaging_dp_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE detail_packaging_dp_id_seq OWNED BY detail_packaging.dp_id;


--
-- Name: detail_packaging_dp_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('detail_packaging_dp_id_seq', 1, false);


--
-- Name: farmer; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE farmer (
    fm_id integer NOT NULL,
    wh_id integer,
    fm_code character varying(255),
    fm_name character varying(255) NOT NULL,
    fm_jk character varying(1),
    fm_address character varying(255),
    fm_no_sertifikasi character varying(255),
    fm_no_hp character varying(25),
    fm_email character varying(100),
    fm_tgl_lahir timestamp without time zone,
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.farmer OWNER TO agripro;

--
-- Name: farmer_fm_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE farmer_fm_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.farmer_fm_id_seq OWNER TO agripro;

--
-- Name: farmer_fm_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE farmer_fm_id_seq OWNED BY farmer.fm_id;


--
-- Name: farmer_fm_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('farmer_fm_id_seq', 3, true);


--
-- Name: groups; Type: TABLE; Schema: public; Owner: optima; Tablespace: 
--

CREATE TABLE groups (
    id integer NOT NULL,
    name character varying(20) NOT NULL,
    description character varying(100) NOT NULL,
    CONSTRAINT check_id CHECK ((id >= 0))
);


ALTER TABLE public.groups OWNER TO optima;

--
-- Name: groups_id_seq; Type: SEQUENCE; Schema: public; Owner: optima
--

CREATE SEQUENCE groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groups_id_seq OWNER TO optima;

--
-- Name: groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: optima
--

ALTER SEQUENCE groups_id_seq OWNED BY groups.id;


--
-- Name: groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: optima
--

SELECT pg_catalog.setval('groups_id_seq', 9, true);


--
-- Name: groups_permissions; Type: TABLE; Schema: public; Owner: optima; Tablespace: 
--

CREATE TABLE groups_permissions (
    id integer NOT NULL,
    group_id integer NOT NULL,
    permission_id integer NOT NULL,
    status character varying(1)
);


ALTER TABLE public.groups_permissions OWNER TO optima;

--
-- Name: groups_permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: optima
--

CREATE SEQUENCE groups_permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groups_permissions_id_seq OWNER TO optima;

--
-- Name: groups_permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: optima
--

ALTER SEQUENCE groups_permissions_id_seq OWNED BY groups_permissions.id;


--
-- Name: groups_permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: optima
--

SELECT pg_catalog.setval('groups_permissions_id_seq', 22, true);


--
-- Name: kota; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE kota (
    kota_id integer NOT NULL,
    prov_id integer,
    kota_name character varying(255),
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.kota OWNER TO agripro;

--
-- Name: kota_kota_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE kota_kota_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kota_kota_id_seq OWNER TO agripro;

--
-- Name: kota_kota_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE kota_kota_id_seq OWNED BY kota.kota_id;


--
-- Name: kota_kota_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('kota_kota_id_seq', 4, true);


--
-- Name: login_attempts; Type: TABLE; Schema: public; Owner: optima; Tablespace: 
--

CREATE TABLE login_attempts (
    id integer NOT NULL,
    ip_address character varying(15),
    login character varying(100) NOT NULL,
    "time" integer,
    CONSTRAINT check_id CHECK ((id >= 0))
);


ALTER TABLE public.login_attempts OWNER TO optima;

--
-- Name: login_attempts_id_seq; Type: SEQUENCE; Schema: public; Owner: optima
--

CREATE SEQUENCE login_attempts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.login_attempts_id_seq OWNER TO optima;

--
-- Name: login_attempts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: optima
--

ALTER SEQUENCE login_attempts_id_seq OWNED BY login_attempts.id;


--
-- Name: login_attempts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: optima
--

SELECT pg_catalog.setval('login_attempts_id_seq', 1, false);


--
-- Name: packaging; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE packaging (
    pkg_id integer NOT NULL,
    prod_id integer,
    pkg_date timestamp without time zone,
    pkg_serial_number character varying(255),
    pkg_batch_number character varying(100),
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.packaging OWNER TO agripro;

--
-- Name: packaging_pkg_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE packaging_pkg_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.packaging_pkg_id_seq OWNER TO agripro;

--
-- Name: packaging_pkg_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE packaging_pkg_id_seq OWNED BY packaging.pkg_id;


--
-- Name: packaging_pkg_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('packaging_pkg_id_seq', 1, false);


--
-- Name: permissions; Type: TABLE; Schema: public; Owner: optima; Tablespace: 
--

CREATE TABLE permissions (
    permission_id integer NOT NULL,
    permission_name character varying(255) NOT NULL,
    permission_description character varying(255)
);


ALTER TABLE public.permissions OWNER TO optima;

--
-- Name: permissions_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: optima
--

CREATE SEQUENCE permissions_permission_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permissions_permission_id_seq OWNER TO optima;

--
-- Name: permissions_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: optima
--

ALTER SEQUENCE permissions_permission_id_seq OWNED BY permissions.permission_id;


--
-- Name: permissions_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: optima
--

SELECT pg_catalog.setval('permissions_permission_id_seq', 43, true);


--
-- Name: plantation; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE plantation (
    plt_id integer NOT NULL,
    fm_id integer,
    kota_id integer,
    prov_id integer,
    plt_code character varying(255) NOT NULL,
    plt_luas_lahan character varying(50) NOT NULL,
    plt_status character varying(100),
    plt_plot integer,
    plt_year_planted character varying(10),
    plt_date_contract timestamp without time zone,
    plt_date_registration timestamp without time zone,
    plt_coordinate character varying(255),
    plt_nama_pemilik character varying(255),
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.plantation OWNER TO agripro;

--
-- Name: plantation_plt_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE plantation_plt_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.plantation_plt_id_seq OWNER TO agripro;

--
-- Name: plantation_plt_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE plantation_plt_id_seq OWNED BY plantation.plt_id;


--
-- Name: plantation_plt_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('plantation_plt_id_seq', 4, true);


--
-- Name: product; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE product (
    prod_id integer NOT NULL,
    prod_code character varying(100),
    prod_name character varying(255),
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.product OWNER TO agripro;

--
-- Name: product_prod_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE product_prod_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.product_prod_id_seq OWNER TO agripro;

--
-- Name: product_prod_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE product_prod_id_seq OWNED BY product.prod_id;


--
-- Name: product_prod_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('product_prod_id_seq', 1, true);


--
-- Name: provinsi; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE provinsi (
    prov_id integer NOT NULL,
    prov_code character varying(255) NOT NULL,
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.provinsi OWNER TO agripro;

--
-- Name: provinsi_prov_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE provinsi_prov_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.provinsi_prov_id_seq OWNER TO agripro;

--
-- Name: provinsi_prov_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE provinsi_prov_id_seq OWNED BY provinsi.prov_id;


--
-- Name: provinsi_prov_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('provinsi_prov_id_seq', 1, true);


--
-- Name: raw_material; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE raw_material (
    rm_id integer NOT NULL,
    rm_code character varying(255),
    rm_name character varying(255) NOT NULL,
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.raw_material OWNER TO agripro;

--
-- Name: raw_material_rm_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE raw_material_rm_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.raw_material_rm_id_seq OWNER TO agripro;

--
-- Name: raw_material_rm_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE raw_material_rm_id_seq OWNED BY raw_material.rm_id;


--
-- Name: raw_material_rm_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('raw_material_rm_id_seq', 2, true);


--
-- Name: stock_material; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE stock_material (
    sm_id integer NOT NULL,
    fm_id integer,
    sm_tgl_masuk timestamp without time zone NOT NULL,
    sm_serial_number character varying(255),
    sm_jenis_pembayaran character varying(50),
    sm_no_po character varying(255),
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.stock_material OWNER TO agripro;

--
-- Name: stock_material_detail; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE stock_material_detail (
    smd_id integer NOT NULL,
    sm_id integer,
    rm_id integer,
    smd_qty double precision,
    smd_harga double precision,
    smd_batch_number character varying(100),
    smd_plt_id integer,
    smd_tgl_panen timestamp without time zone,
    smd_tgl_pengeringan timestamp without time zone,
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.stock_material_detail OWNER TO agripro;

--
-- Name: stock_material_detail_smd_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE stock_material_detail_smd_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.stock_material_detail_smd_id_seq OWNER TO agripro;

--
-- Name: stock_material_detail_smd_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE stock_material_detail_smd_id_seq OWNED BY stock_material_detail.smd_id;


--
-- Name: stock_material_detail_smd_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('stock_material_detail_smd_id_seq', 8, true);


--
-- Name: stock_material_sm_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE stock_material_sm_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.stock_material_sm_id_seq OWNER TO agripro;

--
-- Name: stock_material_sm_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE stock_material_sm_id_seq OWNED BY stock_material.sm_id;


--
-- Name: stock_material_sm_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('stock_material_sm_id_seq', 6, true);


--
-- Name: users; Type: TABLE; Schema: public; Owner: optima; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    ip_address character varying(45),
    username character varying(100),
    password character varying(255) NOT NULL,
    salt character varying(255),
    email character varying(100) NOT NULL,
    activation_code character varying(40),
    forgotten_password_code character varying(40),
    forgotten_password_time integer,
    remember_code character varying(40),
    created_on integer NOT NULL,
    last_login integer,
    active integer,
    first_name character varying(50),
    last_name character varying(50),
    company character varying(100),
    phone character varying(20),
    CONSTRAINT check_active CHECK ((active >= 0)),
    CONSTRAINT check_id CHECK ((id >= 0))
);


ALTER TABLE public.users OWNER TO optima;

--
-- Name: users_groups; Type: TABLE; Schema: public; Owner: optima; Tablespace: 
--

CREATE TABLE users_groups (
    id integer NOT NULL,
    user_id integer NOT NULL,
    group_id integer NOT NULL,
    CONSTRAINT users_groups_check_group_id CHECK ((group_id >= 0)),
    CONSTRAINT users_groups_check_id CHECK ((id >= 0)),
    CONSTRAINT users_groups_check_user_id CHECK ((user_id >= 0))
);


ALTER TABLE public.users_groups OWNER TO optima;

--
-- Name: users_groups_id_seq; Type: SEQUENCE; Schema: public; Owner: optima
--

CREATE SEQUENCE users_groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_groups_id_seq OWNER TO optima;

--
-- Name: users_groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: optima
--

ALTER SEQUENCE users_groups_id_seq OWNED BY users_groups.id;


--
-- Name: users_groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: optima
--

SELECT pg_catalog.setval('users_groups_id_seq', 4, true);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: optima
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO optima;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: optima
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: optima
--

SELECT pg_catalog.setval('users_id_seq', 2, true);


--
-- Name: warehouse; Type: TABLE; Schema: public; Owner: agripro; Tablespace: 
--

CREATE TABLE warehouse (
    wh_id integer NOT NULL,
    wh_code character varying(255),
    wh_name character varying(255) NOT NULL,
    wh_location character varying(255),
    created_date timestamp without time zone,
    created_by character varying(25),
    updated_date timestamp without time zone,
    updated_by character varying(25)
);


ALTER TABLE public.warehouse OWNER TO agripro;

--
-- Name: warehouse_wh_id_seq; Type: SEQUENCE; Schema: public; Owner: agripro
--

CREATE SEQUENCE warehouse_wh_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.warehouse_wh_id_seq OWNER TO agripro;

--
-- Name: warehouse_wh_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: agripro
--

ALTER SEQUENCE warehouse_wh_id_seq OWNED BY warehouse.wh_id;


--
-- Name: warehouse_wh_id_seq; Type: SEQUENCE SET; Schema: public; Owner: agripro
--

SELECT pg_catalog.setval('warehouse_wh_id_seq', 2, true);


--
-- Name: menu_id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE app_menu ALTER COLUMN menu_id SET DEFAULT nextval('app_menu_menu_id_seq'::regclass);


--
-- Name: app_menu_group_id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE app_menu_groups ALTER COLUMN app_menu_group_id SET DEFAULT nextval('app_menu_groups_app_menu_group_id_seq'::regclass);


--
-- Name: dp_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE detail_packaging ALTER COLUMN dp_id SET DEFAULT nextval('detail_packaging_dp_id_seq'::regclass);


--
-- Name: fm_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE farmer ALTER COLUMN fm_id SET DEFAULT nextval('farmer_fm_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE groups ALTER COLUMN id SET DEFAULT nextval('groups_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE groups_permissions ALTER COLUMN id SET DEFAULT nextval('groups_permissions_id_seq'::regclass);


--
-- Name: kota_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE kota ALTER COLUMN kota_id SET DEFAULT nextval('kota_kota_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE login_attempts ALTER COLUMN id SET DEFAULT nextval('login_attempts_id_seq'::regclass);


--
-- Name: pkg_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE packaging ALTER COLUMN pkg_id SET DEFAULT nextval('packaging_pkg_id_seq'::regclass);


--
-- Name: permission_id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE permissions ALTER COLUMN permission_id SET DEFAULT nextval('permissions_permission_id_seq'::regclass);


--
-- Name: plt_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE plantation ALTER COLUMN plt_id SET DEFAULT nextval('plantation_plt_id_seq'::regclass);


--
-- Name: prod_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE product ALTER COLUMN prod_id SET DEFAULT nextval('product_prod_id_seq'::regclass);


--
-- Name: prov_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE provinsi ALTER COLUMN prov_id SET DEFAULT nextval('provinsi_prov_id_seq'::regclass);


--
-- Name: rm_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE raw_material ALTER COLUMN rm_id SET DEFAULT nextval('raw_material_rm_id_seq'::regclass);


--
-- Name: sm_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE stock_material ALTER COLUMN sm_id SET DEFAULT nextval('stock_material_sm_id_seq'::regclass);


--
-- Name: smd_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE stock_material_detail ALTER COLUMN smd_id SET DEFAULT nextval('stock_material_detail_smd_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE users_groups ALTER COLUMN id SET DEFAULT nextval('users_groups_id_seq'::regclass);


--
-- Name: wh_id; Type: DEFAULT; Schema: public; Owner: agripro
--

ALTER TABLE warehouse ALTER COLUMN wh_id SET DEFAULT nextval('warehouse_wh_id_seq'::regclass);


--
-- Data for Name: app_menu; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY app_menu (menu_id, menu_parent, menu_name, menu_icon, menu_desc, menu_link, file_name, listing_no) FROM stdin;
1	0	Administration	icon-user		#	\N	1
3	1	User	\N	\N	\N	administration.users	1
4	1	Role	\N	\N	\N	administration.groups	2
5	1	Permission	\N	\N	\N	administration.permissions	3
2	1	Menu	\N	\N	\N	administration.menus	4
7	1	Role Menu	\N	\N	\N	administration.group_menus	5
8	6	Warehouse	\N	\N	\N	agripro.warehouse	1
9	6	Farmer	\N	\N	\N	agripro.farmer	2
10	6	Raw Material	\N	\N	\N	agripro.raw_material	3
6	0	Tracking			#	\N	2
11	6	Product	\N	\N	\N	agripro.product	4
12	6	Input Material Stock	\N	\N	\N	agripro.stock_material	5
13	6	Input Packaging	\N	\N	\N	agripro.packaging	6
14	6	Tracking Serial Number	\N	\N	\N	agripro.tracking_serial_number	7
\.


--
-- Data for Name: app_menu_groups; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY app_menu_groups (app_menu_group_id, menu_id, group_id, description) FROM stdin;
6	1	1	\N
7	2	1	\N
8	3	1	\N
9	4	1	\N
11	1	2	\N
12	2	2	\N
13	3	2	\N
16	6	1	\N
17	5	1	\N
18	7	1	\N
19	4	2	\N
20	8	1	\N
21	9	1	\N
22	10	1	\N
23	11	1	\N
24	12	1	\N
25	13	1	\N
26	14	1	\N
\.


--
-- Data for Name: detail_packaging; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY detail_packaging (dp_id, smd_id, pkg_id, dp_qty, created_date, created_by, updated_date, updated_by) FROM stdin;
\.


--
-- Data for Name: farmer; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY farmer (fm_id, wh_id, fm_code, fm_name, fm_jk, fm_address, fm_no_sertifikasi, fm_no_hp, fm_email, fm_tgl_lahir, created_date, created_by, updated_date, updated_by) FROM stdin;
2	2	FM001	Budiman	L	Jl. Batik kumeli no 21	STF001	087182371112	budiman@gmail.com	1986-06-14 00:00:00	2016-06-14 00:00:00	admin	2016-06-14 00:00:00	admin
3	1	FM002	Kodir	L	jl.abc no 21				1977-08-23 00:00:00	2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
\.


--
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY groups (id, name, description) FROM stdin;
1	admin	Administrator
2	customer	ATN Customer
\.


--
-- Data for Name: groups_permissions; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY groups_permissions (id, group_id, permission_id, status) FROM stdin;
2	1	9	Y
3	1	23	Y
4	1	25	Y
5	1	28	Y
6	1	29	Y
7	1	30	Y
8	1	31	Y
9	1	32	Y
10	1	33	Y
11	1	34	Y
12	1	35	Y
13	1	36	Y
14	1	37	Y
15	1	38	Y
16	1	39	Y
1	1	1	Y
19	1	43	Y
20	1	42	Y
21	1	41	Y
22	1	40	Y
\.


--
-- Data for Name: kota; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY kota (kota_id, prov_id, kota_name, created_date, created_by, updated_date, updated_by) FROM stdin;
1	1	KOTA BANDUNG	2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
2	1	KOTA BOGOR	2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
3	2	JAKARTA UTARA	2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
4	2	JAKARTA SELATAN	2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
\.


--
-- Data for Name: login_attempts; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY login_attempts (id, ip_address, login, "time") FROM stdin;
\.


--
-- Data for Name: packaging; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY packaging (pkg_id, prod_id, pkg_date, pkg_serial_number, pkg_batch_number, created_date, created_by, updated_date, updated_by) FROM stdin;
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY permissions (permission_id, permission_name, permission_description) FROM stdin;
28	view-role	View Role Permission
29	add-role	Add Role Permission
30	edit-role	Edit Role Permission
31	delete-role	Delete Role Permission
32	view-permission	View Permission
33	add-permission	Add Permission
34	edit-permission	Edit Permission
35	delete-permission	Delete Permission
36	view-menu	View Menu Permission
37	add-menu	Add Menu Permission
38	edit-menu	Edit Menu Permission
39	delete-menu	Delete Menu Permission
9	add-user	Add User Permission
1	view-user	View User Permission
23	edit-user	Edit User Permission
25	delete-user	Delete User Permission
40	add-tracking	Add Tracking Permission
41	edit-tracking	Edit Tracking Permission
42	delete-tracking	Delete Tracking Permission
43	view-tracking	View Tracking Permission
\.


--
-- Data for Name: plantation; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY plantation (plt_id, fm_id, kota_id, prov_id, plt_code, plt_luas_lahan, plt_status, plt_plot, plt_year_planted, plt_date_contract, plt_date_registration, plt_coordinate, plt_nama_pemilik, created_date, created_by, updated_date, updated_by) FROM stdin;
3	2	1	1	PLT001-01	12000Ha	Milik	10	2016	2016-06-01 00:00:00	2016-06-15 00:00:00	-1.3213,9.3213	Wiliam Decosta	2016-06-14 00:00:00	admin	2016-06-15 00:00:00	admin
4	3	4	2	PLT002-01	1000Ha	Milik	0		\N	\N		Kodirun	2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
\.


--
-- Data for Name: product; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY product (prod_id, prod_code, prod_name, created_date, created_by, updated_date, updated_by) FROM stdin;
1	PROD-001	TAHUBULAT	2016-06-14 00:00:00	admin	2016-06-14 00:00:00	admin
\.


--
-- Data for Name: provinsi; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY provinsi (prov_id, prov_code, created_date, created_by, updated_date, updated_by) FROM stdin;
1	JAWA BARAT	2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
2	DKI JAKARTA	2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
\.


--
-- Data for Name: raw_material; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY raw_material (rm_id, rm_code, rm_name, created_date, created_by, updated_date, updated_by) FROM stdin;
1	KM001	Kayu Manis	2016-06-14 00:00:00	admin	2016-06-14 00:00:00	admin
2	CK001	Cengkeh	2016-06-14 00:00:00	admin	2016-06-14 00:00:00	admin
\.


--
-- Data for Name: stock_material; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY stock_material (sm_id, fm_id, sm_tgl_masuk, sm_serial_number, sm_jenis_pembayaran, sm_no_po, created_date, created_by, updated_date, updated_by) FROM stdin;
6	2	2016-06-15 00:00:00	ATN-FM001-20160615-0001	\N		2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
\.


--
-- Data for Name: stock_material_detail; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY stock_material_detail (smd_id, sm_id, rm_id, smd_qty, smd_harga, smd_batch_number, smd_plt_id, smd_tgl_panen, smd_tgl_pengeringan, created_date, created_by, updated_date, updated_by) FROM stdin;
8	6	1	4.5	150000	ATN-FM001-20160615-0001/0001	3	2016-06-15 00:00:00	2016-06-30 00:00:00	2016-06-15 00:00:00	admin	2016-06-15 00:00:00	admin
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY users (id, ip_address, username, password, salt, email, activation_code, forgotten_password_code, forgotten_password_time, remember_code, created_on, last_login, active, first_name, last_name, company, phone) FROM stdin;
1	127.0.0.1	admin	$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36		admin@admin.com		\N	\N	\N	1268889823	1465915394	1	Admin	istrator	ADMIN	0
2	\N	customer	$2y$08$9eWSfva.QOw2YZNyo8IOlOmOXTG3qAx3mOIuKyLTBvFT0/SLrNR02	\N	customer@gmail.com	\N	\N	\N	\N	1464147806	1464152213	1	\N	\N	\N	
\.


--
-- Data for Name: users_groups; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY users_groups (id, user_id, group_id) FROM stdin;
1	1	1
2	1	2
3	2	2
\.


--
-- Data for Name: warehouse; Type: TABLE DATA; Schema: public; Owner: agripro
--

COPY warehouse (wh_id, wh_code, wh_name, wh_location, created_date, created_by, updated_date, updated_by) FROM stdin;
2	WH-002	Warehouse 02	Jl. abc no 02	2016-06-14 00:00:00	admin	2016-06-14 00:00:00	admin
1	WH-001	Warehouse 01	Jl. abc no 01	2016-06-14 00:00:00	admin	2016-06-14 00:00:00	admin
\.


--
-- Name: app_menu_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY app_menu_groups
    ADD CONSTRAINT app_menu_groups_pkey PRIMARY KEY (app_menu_group_id);


--
-- Name: app_menu_groups_uq; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY app_menu_groups
    ADD CONSTRAINT app_menu_groups_uq UNIQUE (menu_id, group_id);


--
-- Name: app_menu_pkey; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY app_menu
    ADD CONSTRAINT app_menu_pkey PRIMARY KEY (menu_id);


--
-- Name: groups_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY groups_permissions
    ADD CONSTRAINT groups_permissions_pkey PRIMARY KEY (id);


--
-- Name: groups_pkey; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);


--
-- Name: login_attempts_pkey; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY login_attempts
    ADD CONSTRAINT login_attempts_pkey PRIMARY KEY (id);


--
-- Name: permission_id_pk; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY permissions
    ADD CONSTRAINT permission_id_pk PRIMARY KEY (permission_id);


--
-- Name: pk_detail_packaging; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY detail_packaging
    ADD CONSTRAINT pk_detail_packaging PRIMARY KEY (dp_id);


--
-- Name: pk_farmer; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY farmer
    ADD CONSTRAINT pk_farmer PRIMARY KEY (fm_id);


--
-- Name: pk_kota; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY kota
    ADD CONSTRAINT pk_kota PRIMARY KEY (kota_id);


--
-- Name: pk_packaging; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY packaging
    ADD CONSTRAINT pk_packaging PRIMARY KEY (pkg_id);


--
-- Name: pk_plantation; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY plantation
    ADD CONSTRAINT pk_plantation PRIMARY KEY (plt_id);


--
-- Name: pk_product; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY product
    ADD CONSTRAINT pk_product PRIMARY KEY (prod_id);


--
-- Name: pk_provinsi; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY provinsi
    ADD CONSTRAINT pk_provinsi PRIMARY KEY (prov_id);


--
-- Name: pk_raw_material; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY raw_material
    ADD CONSTRAINT pk_raw_material PRIMARY KEY (rm_id);


--
-- Name: pk_stock_material; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY stock_material
    ADD CONSTRAINT pk_stock_material PRIMARY KEY (sm_id);


--
-- Name: pk_stock_material_detail; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY stock_material_detail
    ADD CONSTRAINT pk_stock_material_detail PRIMARY KEY (smd_id);


--
-- Name: pk_warehouse; Type: CONSTRAINT; Schema: public; Owner: agripro; Tablespace: 
--

ALTER TABLE ONLY warehouse
    ADD CONSTRAINT pk_warehouse PRIMARY KEY (wh_id);


--
-- Name: uc_users_groups; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY users_groups
    ADD CONSTRAINT uc_users_groups UNIQUE (user_id, group_id);


--
-- Name: users_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY users_groups
    ADD CONSTRAINT users_groups_pkey PRIMARY KEY (id);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: optima; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: detail_packaging_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX detail_packaging_pk ON detail_packaging USING btree (dp_id);


--
-- Name: farmer_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX farmer_pk ON farmer USING btree (fm_id);


--
-- Name: kota_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX kota_pk ON kota USING btree (kota_id);


--
-- Name: packaging_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX packaging_pk ON packaging USING btree (pkg_id);


--
-- Name: plantation_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX plantation_pk ON plantation USING btree (plt_id);


--
-- Name: product_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX product_pk ON product USING btree (prod_id);


--
-- Name: provinsi_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX provinsi_pk ON provinsi USING btree (prov_id);


--
-- Name: r10_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r10_fk ON stock_material_detail USING btree (rm_id);


--
-- Name: r11_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r11_fk ON packaging USING btree (prod_id);


--
-- Name: r12_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r12_fk ON detail_packaging USING btree (smd_id);


--
-- Name: r13_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r13_fk ON plantation USING btree (kota_id);


--
-- Name: r14_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r14_fk ON plantation USING btree (prov_id);


--
-- Name: r1_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r1_fk ON farmer USING btree (wh_id);


--
-- Name: r5_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r5_fk ON detail_packaging USING btree (pkg_id);


--
-- Name: r6_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r6_fk ON plantation USING btree (fm_id);


--
-- Name: r7_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r7_fk ON kota USING btree (prov_id);


--
-- Name: r8_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r8_fk ON stock_material USING btree (fm_id);


--
-- Name: r9_fk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE INDEX r9_fk ON stock_material_detail USING btree (sm_id);


--
-- Name: raw_material_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX raw_material_pk ON raw_material USING btree (rm_id);


--
-- Name: stock_material_detail_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX stock_material_detail_pk ON stock_material_detail USING btree (smd_id);


--
-- Name: stock_material_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX stock_material_pk ON stock_material USING btree (sm_id);


--
-- Name: warehouse_pk; Type: INDEX; Schema: public; Owner: agripro; Tablespace: 
--

CREATE UNIQUE INDEX warehouse_pk ON warehouse USING btree (wh_id);


--
-- Name: fk_detail_p_r12_stock_ma; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY detail_packaging
    ADD CONSTRAINT fk_detail_p_r12_stock_ma FOREIGN KEY (smd_id) REFERENCES stock_material_detail(smd_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_detail_p_r5_packagin; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY detail_packaging
    ADD CONSTRAINT fk_detail_p_r5_packagin FOREIGN KEY (pkg_id) REFERENCES packaging(pkg_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_farmer_r1_warehous; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY farmer
    ADD CONSTRAINT fk_farmer_r1_warehous FOREIGN KEY (wh_id) REFERENCES warehouse(wh_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_kota_r7_provinsi; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY kota
    ADD CONSTRAINT fk_kota_r7_provinsi FOREIGN KEY (prov_id) REFERENCES provinsi(prov_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_packagin_r11_product; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY packaging
    ADD CONSTRAINT fk_packagin_r11_product FOREIGN KEY (prod_id) REFERENCES product(prod_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_plantati_r13_kota; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY plantation
    ADD CONSTRAINT fk_plantati_r13_kota FOREIGN KEY (kota_id) REFERENCES kota(kota_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_plantati_r14_provinsi; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY plantation
    ADD CONSTRAINT fk_plantati_r14_provinsi FOREIGN KEY (prov_id) REFERENCES provinsi(prov_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_plantati_r6_farmer; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY plantation
    ADD CONSTRAINT fk_plantati_r6_farmer FOREIGN KEY (fm_id) REFERENCES farmer(fm_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_stock_ma_r10_raw_mate; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY stock_material_detail
    ADD CONSTRAINT fk_stock_ma_r10_raw_mate FOREIGN KEY (rm_id) REFERENCES raw_material(rm_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_stock_ma_r8_farmer; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY stock_material
    ADD CONSTRAINT fk_stock_ma_r8_farmer FOREIGN KEY (fm_id) REFERENCES farmer(fm_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_stock_ma_r9_stock_ma; Type: FK CONSTRAINT; Schema: public; Owner: agripro
--

ALTER TABLE ONLY stock_material_detail
    ADD CONSTRAINT fk_stock_ma_r9_stock_ma FOREIGN KEY (sm_id) REFERENCES stock_material(sm_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: group_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: optima
--

ALTER TABLE ONLY groups_permissions
    ADD CONSTRAINT group_id_fk FOREIGN KEY (group_id) REFERENCES groups(id);


--
-- Name: permission_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: optima
--

ALTER TABLE ONLY groups_permissions
    ADD CONSTRAINT permission_id_fk FOREIGN KEY (permission_id) REFERENCES permissions(permission_id);


--
-- Name: public; Type: ACL; Schema: -; Owner: enterprisedb
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM enterprisedb;
GRANT ALL ON SCHEMA public TO enterprisedb;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- EnterpriseDB database dump complete
--

