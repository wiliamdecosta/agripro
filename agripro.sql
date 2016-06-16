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

SELECT pg_catalog.setval('stock_material_sm_id_seq', 7, true);


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
1	25	Kab Luwu Utara 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
2	14	Kab Tana Tidung	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
3	1	Kab. Aceh Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
4	1	Kab. Aceh Barat Daya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
5	1	Kab. Aceh Besar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
6	1	Kab. Aceh Jaya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
7	1	Kab. Aceh Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
8	1	Kab. Aceh Singkil	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
9	1	Kab. Aceh Tamiang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
10	1	Kab. Aceh Tengah	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
11	1	Kab. Aceh Tenggara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
12	1	Kab. Aceh Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
13	1	Kab. Aceh Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
14	7	Kab. Administrasi Kepulauan Seribu	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
15	29	Kab. Agam	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
16	20	Kab. Alor	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
17	31	Kab. Asahan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
18	22	Kab. Asmat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
19	2	Kab. Badung 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
20	12	Kab. Balangan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
21	8	Kab. Bandung 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
22	8	Kab. Bandung Barat 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
23	26	Kab. Banggai	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
24	26	Kab. Banggai Kepulauan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
25	15	Kab. Bangka 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
26	15	Kab. Bangka Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
27	15	Kab. Bangka Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
28	15	Kab. Bangka Tengah	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
29	10	Kab. Bangkalan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
30	2	Kab. Bangli 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
31	12	Kab. Banjar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
32	9	Kab. Banjarnegara 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
33	25	Kab. Bantaeng	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
34	5	Kab. Bantul 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
35	30	Kab. Banyuasin 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
36	9	Kab. Banyumas 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
37	10	Kab. Banyuwangi 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
38	12	Kab. Barito Kuala	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
39	12	Kab. Barito Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
40	12	Kab. Barito Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
41	12	Kab. Barito Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
42	25	Kab. Barru	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
43	9	Kab. Batang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
44	4	Kab. Batang Hari	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
45	31	Kab. Batubara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
46	8	Kab. Bekasi 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
47	15	Kab. Belitung 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
48	15	Kab. Belitung Timur 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
49	20	Kab. Belu	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
50	1	Kab. Bener Meriah	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
51	23	Kab. Bengkalis 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
52	11	Kab. Bengkayang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
53	4	Kab. Bengkulu Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
54	4	Kab. Bengkulu Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
55	14	Kab. Berau	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
56	21	Kab. Biak Numfor	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
57	19	Kab. Bima 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
58	15	Kab. Bintan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
59	1	Kab. Bireuen	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
60	10	Kab. Blitar 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
61	9	Kab. Blora 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
62	6	Kab. Boalemo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
63	8	Kab. Bogor 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
64	10	Kab. Bojonegoro 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
65	28	Kab. Bolaang Mongondow	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
66	28	Kab. Bolaang Mongondow Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
67	25	Kab. Bombana	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
68	10	Kab. Bondowoso 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
69	25	Kab. Bone	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
70	6	Kab. Bone Bolango	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
71	21	Kab. Boven Digoel	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
72	9	Kab. Boyolali 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
73	9	Kab. Brebes 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
74	2	Kab. Buleleng 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
75	25	Kab. Bulukumba	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
76	14	Kab. Bulungan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
77	4	Kab. Bungo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
78	26	Kab. Buol	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
79	17	Kab. Buru	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
80	27	Kab. Buton & Buton Utara 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
81	8	Kab. Ciamis 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
82	8	Kab. Cianjur 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
83	9	Kab. Cilacap 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
84	8	Kab. Cirebon 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
85	31	Kab. Dairi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
86	31	Kab. Deli Serdang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
87	9	Kab. Demak 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
88	29	Kab. Dharmasraya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
89	19	Kab. Dompu 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
90	26	Kab. Donggala	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
91	30	Kab. Empat Lawang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
92	20	Kab. Ende	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
93	25	Kab. Enrekang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
94	22	Kab. Fak-Fak	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
95	20	Kab. Flores Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
96	8	Kab. Garut 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
97	1	Kab. Gayo Lues	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
98	2	Kab. Gianyar 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
99	6	Kab. Gorontalo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
100	6	Kab. Gorontalo Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
101	25	Kab. Gowa	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
102	10	Kab. Gresik 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
103	9	Kab. Grobogan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
104	5	Kab. Gunung Kidul 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
105	13	Kab. Gunung Mas	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
106	18	Kab. Halmahera Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
107	18	Kab. Halmahera Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
108	18	Kab. Halmahera Tengah	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
109	18	Kab. Halmahera Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
110	18	Kab. Halmahera Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
111	12	Kab. Hulu Sungai Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
112	12	Kab. Hulu Sungai Tengah	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
113	12	Kab. Hulu Sungai Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
114	31	Kab. Humbang Hasudutan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
115	23	Kab. Indragiri Hilir 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
116	23	Kab. Indragiri Hulu 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
117	8	Kab. Indramayu 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
118	21	Kab. Jayapura	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
119	21	Kab. Jayawijaya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
120	10	Kab. Jember 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
121	2	Kab. Jembrana 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
122	25	Kab. Jeneponto	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
123	9	Kab. Jepara 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
124	10	Kab. Jombang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
125	22	Kab. Kaimana	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
126	23	Kab. Kampar 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
127	13	Kab. Kapuas	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
128	11	Kab. Kapuas Hulu	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
129	9	Kab. Karanganyar 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
130	2	Kab. Karangasem 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
131	8	Kab. Karawang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
132	15	Kab. Karimun	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
133	31	Kab. Karo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
134	13	Kab. Katingan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
135	4	Kab. Kaur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
136	11	Kab. Kayong Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
137	9	Kab. Kebumen 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
138	10	Kab. Kediri 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
139	21	Kab. Keerom	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
140	9	Kab. Kendal 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
141	4	Kab. Kepahiang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
142	17	Kab. Kepulauan Aru	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
143	28	Kab. Kepulauan Sangihe	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
144	18	Kab. Kepulauan Sula	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
145	28	Kab. Kepulauan Talaud	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
146	29	Kab. Kepulaun Mentawai 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
147	4	Kab. Kerinci	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
148	11	Kab. Ketapang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
149	9	kab. Klaten 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
150	2	Kab. Klungkung 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
151	27	Kab. Kolaka	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
152	27	Kab. Kolaka Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
153	27	Kab. Konawe	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
154	27	Kab. Konawe Utara/Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
155	12	Kab. Kota Baru	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
156	13	Kab. Kotawaringin Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
157	13	Kab. Kotawaringin Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
158	23	Kab. Kuantan Singingi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
159	11	Kab. Kubu Raya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
160	9	Kab. Kudus 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
161	5	Kab. Kulon Progo 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
162	8	Kab. Kuningan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
163	20	Kab. Kupang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
164	14	Kab. Kutai Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
165	14	Kab. Kutai Kartanegara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
166	14	Kab. Kutai Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
167	31	Kab. Labuhan Batu	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
168	30	Kab. Lahat 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
169	13	Kab. Lamandau	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
170	10	Kab. Lamongan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
171	16	Kab. Lampung Barat 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
172	16	Kab. Lampung Selatan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
173	16	kab. Lampung Tengah 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
174	16	Kab. Lampung Timur 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
175	16	Kab. Lampung Utara 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
176	11	Kab. Landak	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
177	31	Kab. Langkat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
178	3	Kab. Lebak	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
179	4	Kab. Lebong	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
180	20	Kab. Lembata	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
181	29	Kab. Lima Puluh Kota 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
182	15	Kab. Lingga 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
183	19	Kab. Lombok Barat 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
184	19	Kab. Lombok Tengah 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
185	19	Kab. Lombok Timur 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
186	10	Kab. Lumajang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
187	25	Kab. Luwu Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
188	25	Kab. Luwu Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
189	21	Kab. Maapi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
190	10	Kab. Madiun 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
191	9	Kab. Magelang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
192	10	Kab. Magetan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
193	8	Kab. Majalengka 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
194	24	Kab. Majene	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
195	10	Kab. Malang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
196	14	Kab. Malinau	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
197	17	Kab. Maluku Tengah	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
198	17	Kab. Maluku Tenggara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
199	17	Kab. Maluku Tenggara Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
200	24	Kab. Mamasa	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
201	21	Kab. Mamberamo Raya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
202	24	Kab. Mamuju	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
203	24	Kab. Mamuju Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
204	31	Kab. Mandailing Natal	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
205	20	Kab. Manggarai   	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
206	20	Kab. Manggarai Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
207	20	Kab. Manggarai timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
208	21	Kab. Manokwari	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
209	25	Kab. Maros	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
210	11	Kab. Melawi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
211	4	Kab. Merangin	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
212	21	Kab. Merauke	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
213	21	Kab. Mimika	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
214	28	Kab. Minahasa	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
215	28	Kab. Minahasa Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
216	28	Kab. Minahasa Tenggara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
217	28	Kab. Minahasa Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
218	10	Kab. Mojokerto 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
219	26	Kab. Morowali	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
220	30	Kab. Muara Enim 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
221	4	Kab. Muaro Jambi 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
222	4	Kab. Muko-muko	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
223	27	Kab. Muna	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
224	12	Kab. Murung Raya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
225	30	Kab. Musi Banyuasin 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
226	30	Kab. Musi Rawas 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
227	21	Kab. Nabire	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
228	1	Kab. Nagan Raya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
229	20	Kab. Nagekeo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
230	15	Kab. Natuna 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
231	20	Kab. Ngada	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
232	10	Kab. Nganjuk 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
233	10	Kab. Ngawi 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
234	31	Kab. Nias	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
235	31	Kab. Nias Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
236	14	Kab. Nunukan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
237	30	Kab. Ogan Ilir 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
238	30	Kab. Ogan Komering Ilir 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
239	30	Kab. Ogan Komering Ulu 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
240	30	Kab. Ogan Komering Ulu Timur 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
241	30	Kab. Organ Komering Ulu Selatan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
242	10	Kab. Pacitan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
243	31	Kab. Padang Lawas	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
244	31	Kab. Padang Lawas Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
245	29	Kab. Padang Pariaman 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
246	6	Kab. Pahuwato	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
247	31	Kab. Pakpak Bharat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
248	23	Kab. Palalawan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
249	10	Kab. Pamekasan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
250	3	Kab. Pandeglang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
251	25	Kab. Pangkajene Kepulauan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
252	21	Kab. Paniai	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
253	26	Kab. Parigi Moutong	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
254	29	Kab. Pasaman 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
255	14	Kab. Paser	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
256	10	Kab. Pasuruan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
257	9	Kab. Pati 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
258	21	Kab. Pegunungan Bintang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
259	9	Kab. Pekalongan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
260	9	Kab. Pemalang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
261	14	Kab. Penajam Paser Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
262	16	Kab. Pesawaran 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
263	29	Kab. Pesisir Selatan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
264	1	Kab. Pidie	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
265	1	Kab. Pidie Jaya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
266	25	Kab. Pinrang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
267	24	Kab. Polewali Mandar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
268	10	Kab. Ponorogo 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
269	11	Kab. Pontianak	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
270	26	Kab. Poso	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
271	10	Kab. Probolinggo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
272	12	Kab. Pulang Pisau	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
273	21	Kab. Puncak Jaya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
274	9	Kab. Purbalingga 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
275	8	Kab. Purwakarta 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
276	9	Kab. Purworejo 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
277	22	Kab. Raja Ampat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
278	4	Kab. Rejang Lebong	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
279	9	Kab. Rembang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
280	23	Kab. Rokan Hilir 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
281	23	Kab. Rokan Hulu 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
282	20	Kab. Rote Ndao	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
283	11	Kab. Sambas	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
284	31	Kab. Samosir	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
285	10	Kab. Sampang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
286	11	Kab. Sanggau	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
287	21	Kab. Sarmi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
288	4	Kab. Sarolangun 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
289	11	Kab. Sekadau	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
290	25	Kab. Selayar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
291	4	Kab. Seluma	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
292	9	Kab. Semarang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
293	17	Kab. Seram Bagian Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
294	17	Kab. Seram Bagian Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
295	3	Kab. Serang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
296	31	Kab. Serdang Bedagai	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
297	12	Kab. Seruyan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
298	23	Kab. Siak 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
299	25	Kab. Sidenreng Rappang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
300	10	Kab. Sidoarjo 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
301	29	Kab. Sijunjung 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
302	20	Kab. Sikka	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
303	31	Kab. Simalungun	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
304	1	Kab. Simeulue	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
305	25	Kab. Sinjai	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
306	11	Kab. Sintang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
307	10	Kab. Situbondo 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
308	5	Kab. Sleman 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
309	29	Kab. Solok 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
310	29	Kab. Solok Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
311	25	Kab. Soppeng	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
312	22	Kab. Sorong	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
313	22	Kab. Sorong Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
314	9	Kab. Sragen 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
315	8	Kab. Subang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
316	8	Kab. Sukabumi 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
317	12	Kab. Sukamara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
318	9	Kab. Sukoharjo 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
319	20	Kab. Sumba Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
320	20	Kab. Sumba Barat Daya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
321	20	Kab. Sumba Tengah	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
322	20	Kab. Sumba Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
323	19	Kab. Sumbawa 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
324	19	Kab. Sumbawa Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
325	8	Kab. Sumedang 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
326	10	Kab. Sumenep 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
327	21	Kab. Supiori	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
328	12	Kab. Tabalong	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
329	2	Kab. Tabanan 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
330	25	Kab. Takalar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
331	25	Kab. Tana Toraja	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
332	12	Kab. Tanah Bambu	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
333	29	Kab. Tanah Datar 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
334	12	Kab. Tanah Laut	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
335	3	Kab. Tangerang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
336	16	Kab. Tanggamus 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
337	4	Kab. Tanjung Jabung Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
338	4	Kab. Tanjung Jabung Timur 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
339	31	Kab. Tapanuli Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
340	31	Kab. Tapanuli Tengah	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
341	31	Kab. Tapanuli Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
342	12	Kab. Tapin	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
343	8	Kab. Tasikmalaya 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
344	4	Kab. Tebo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
345	9	Kab. Tegal 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
346	22	Kab. Teluk Bintuni	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
347	22	Kab. Teluk Wondama	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
348	9	Kab. Temanggung 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
349	20	Kab. Timor Tengah Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
350	31	Kab. Toba Samosir	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
351	26	Kab. Tojo Una-Una	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
352	21	Kab. Tolikora	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
353	26	Kab. Toli-Toli	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
354	10	Kab. Trenggalek 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
355	10	Kab. Tuban 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
356	16	kab. Tulang Bawang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
357	10	Kab. Tulungagung 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
358	25	Kab. Wajo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
359	27	Kab. Wakatobi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
360	21	Kab. Waropen	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
361	16	Kab. Way Kanan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
362	9	Kab. Wonogiri 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
363	9	Kab. Wonosobo 	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
364	21	Kab. Yahukimo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
365	21	Kab. Yapen Waropen	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
366	20	Kab.TimorTengah Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
367	7	Kota Administrasi Jakarta Barat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
368	7	Kota Administrasi Jakarta Pusat	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
369	7	Kota Administrasi Jakarta Selatan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
370	7	Kota Administrasi Jakarta Timur	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
371	7	Kota Administrasi Jakarta Utara	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
372	17	Kota Ambon	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
373	14	Kota Balikpapan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
374	1	Kota Banda Aceh	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
375	16	Kota Bandar Lampung	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
376	8	Kota Bandung	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
377	8	Kota Banjar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
378	12	Kota Banjarbaru	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
379	12	Kota Banjarmasin	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
380	15	Kota Batam	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
381	10	Kota Batu	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
382	27	Kota Bau-Bau	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
383	8	Kota Bekasi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
384	4	Kota Bengkulu	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
385	19	Kota Bima	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
386	31	Kota Binjai	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
387	28	Kota Bitung	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
388	10	Kota Blitar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
389	8	Kota Bogor	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
390	14	Kota Bontang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
391	29	Kota Bukittinggi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
392	3	Kota Cilegon	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
393	8	Kota Cimahi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
394	8	Kota Cirebon	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
395	2	Kota Denpasar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
396	8	Kota Depok	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
397	23	Kota Dumai	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
398	6	Kota Gorontalo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
399	4	Kota Jambi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
400	21	Kota Jayapura	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
401	10	Kota Kediri	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
402	27	Kota Kendari	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
403	20	Kota Kupang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
404	1	Kota Langsa	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
405	1	Kota Lhokseumawe	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
406	30	Kota Lubuk Linggau	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
407	10	Kota Madiun	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
408	9	Kota Magelang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
409	25	Kota Makassar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
410	10	Kota Malang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
411	28	Kota Manado	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
412	19	Kota Mataram	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
413	31	Kota Medan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
414	16	Kota Metro	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
415	10	Kota Mojokerto	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
416	29	Kota Padang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
417	29	Kota Padang Panjang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
418	31	Kota Padang Sidempuan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
419	30	Kota Pagar Alam	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
420	12	Kota Palangka Raya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
421	30	Kota Palembang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
422	25	Kota Palopo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
423	26	Kota Palu	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
424	15	Kota Pangkal Pinang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
425	25	Kota Pare-Pare	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
426	29	Kota Pariaman	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
427	10	Kota Pasuruan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
428	29	Kota Payakumbuh	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
429	9	Kota Pekalongan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
430	23	Kota Pekanbaru	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
431	31	Kota Pematangsiantar	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
432	11	Kota Pontianak	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
433	30	Kota Prabumulih	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
434	10	Kota Probolinggo	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
435	1	Kota Sabang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
436	9	Kota Salatiga	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
437	14	Kota Samarinda	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
438	29	Kota Sawahlunto	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
439	9	Kota Semarang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
440	3	Kota Serang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
441	31	Kota Sibolga	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
442	11	Kota Singkawang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
443	29	Kota Solok	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
444	22	Kota Sorong	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
445	1	Kota Subulussalam	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
446	8	Kota Sukabumi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
447	10	Kota Surabaya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
448	9	Kota Surakarta	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
449	3	Kota Tangerang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
450	31	Kota Tanjung Balai	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
451	15	Kota Tanjung Pinang	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
452	14	Kota Tarakan	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
453	8	Kota Tasikmalaya	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
454	31	Kota Tebing Tinggi	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
455	9	Kota Tegal	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
456	18	Kota Ternate	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
457	18	Kota Tidore	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
458	28	Kota Tomohon	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
459	5	Kota Yogyakarta	2016-06-16 18:53:48	admin	2016-06-16 18:53:48	admin
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
1	ACEH	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
2	BALI	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
3	BANTEN	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
4	BENGKULU	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
5	D.I. YOGYAKARTA	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
6	GORONTALO	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
7	JAKARTA	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
8	JAWA BARAT	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
9	JAWA TENGAH	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
10	JAWA TIMUR	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
11	KALIMANTAN BARAT	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
12	KALIMANTAN SELATAN	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
13	KALIMANTAN TENGAH	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
14	KALIMANTAN TIMUR	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
15	KEPULAUAN BANGKA BELITUNG	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
16	LAMPUNG	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
17	MALUKU	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
18	MALUKU UTARA	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
19	NTB	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
20	NTT	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
21	PAPUA	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
22	PAPUA BARAT	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
23	RIAU	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
24	SULAWESI BARAT	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
25	SULAWESI SELATAN	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
26	SULAWESI TENGAH	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
27	SULAWESI TENGGARA	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
28	SULAWESI UTARA	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
29	SUMATERA BARAT	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
30	SUMATERA SELATAN	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
31	SUMATERA UTARA	2016-06-16 18:52:21	admin	2016-06-16 18:52:21	admin
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
7	2	2016-06-16 00:00:00	ATN-FM001-20160616-0001	\N		2016-06-16 00:00:00	admin	2016-06-16 00:00:00	admin
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
2	\N	customer	$2y$08$9eWSfva.QOw2YZNyo8IOlOmOXTG3qAx3mOIuKyLTBvFT0/SLrNR02	\N	customer@gmail.com	\N	\N	\N	\N	1464147806	1464152213	1	\N	\N	\N	
1	127.0.0.1	admin	$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36		admin@admin.com		\N	\N	\N	1268889823	1466077567	1	Admin	istrator	ADMIN	0
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

