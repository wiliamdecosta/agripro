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

SELECT pg_catalog.setval('app_menu_groups_app_menu_group_id_seq', 19, true);


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

SELECT pg_catalog.setval('app_menu_menu_id_seq', 7, true);


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

SELECT pg_catalog.setval('groups_id_seq', 8, true);


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

SELECT pg_catalog.setval('groups_permissions_id_seq', 18, true);


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

SELECT pg_catalog.setval('permissions_permission_id_seq', 39, true);


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

SELECT pg_catalog.setval('users_groups_id_seq', 3, true);


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
-- Name: menu_id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE app_menu ALTER COLUMN menu_id SET DEFAULT nextval('app_menu_menu_id_seq'::regclass);


--
-- Name: app_menu_group_id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE app_menu_groups ALTER COLUMN app_menu_group_id SET DEFAULT nextval('app_menu_groups_app_menu_group_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE groups ALTER COLUMN id SET DEFAULT nextval('groups_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE groups_permissions ALTER COLUMN id SET DEFAULT nextval('groups_permissions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE login_attempts ALTER COLUMN id SET DEFAULT nextval('login_attempts_id_seq'::regclass);


--
-- Name: permission_id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE permissions ALTER COLUMN permission_id SET DEFAULT nextval('permissions_permission_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: optima
--

ALTER TABLE users_groups ALTER COLUMN id SET DEFAULT nextval('users_groups_id_seq'::regclass);


--
-- Data for Name: app_menu; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY app_menu (menu_id, menu_parent, menu_name, menu_icon, menu_desc, menu_link, file_name, listing_no) FROM stdin;
1	0	Administration	icon-user		#	\N	1
6	0	Parameters			#	\N	2
3	1	User	\N	\N	\N	administration.users	1
4	1	Role	\N	\N	\N	administration.groups	2
5	1	Permission	\N	\N	\N	administration.permissions	3
2	1	Menu	\N	\N	\N	administration.menus	4
7	1	Role Menu	\N	\N	\N	administration.group_menus	5
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
\.


--
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY groups (id, name, description) FROM stdin;
1	admin	Administrator
2	members	General User
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
\.


--
-- Data for Name: login_attempts; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY login_attempts (id, ip_address, login, "time") FROM stdin;
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
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: optima
--

COPY users (id, ip_address, username, password, salt, email, activation_code, forgotten_password_code, forgotten_password_time, remember_code, created_on, last_login, active, first_name, last_name, company, phone) FROM stdin;
2	\N	operator	$2y$08$9eWSfva.QOw2YZNyo8IOlOmOXTG3qAx3mOIuKyLTBvFT0/SLrNR02	\N	operator@gmail.com	\N	\N	\N	\N	1464147806	1464152213	1	\N	\N	\N
1	127.0.0.1	admin	$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36		admin@admin.com		\N	\N	\N	1268889823	1464252428	1	Admin	istrator	ADMIN	0
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

