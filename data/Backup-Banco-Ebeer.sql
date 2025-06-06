PGDMP  -    9                }            e-beer    16.4    16.4 �    v           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            w           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            x           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            y           1262    18290    e-beer    DATABASE        CREATE DATABASE "e-beer" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Portuguese_Brazil.1252';
    DROP DATABASE "e-beer";
                postgres    false            �            1255    18524 %   recomendar_cerveja(character varying)    FUNCTION     �  CREATE FUNCTION public.recomendar_cerveja(cpf_usuario character varying) RETURNS TABLE(cpf_usuario_out character varying, nome_usuario character varying, id_cerveja_recomendada integer, id_questionario integer)
    LANGUAGE plpgsql
    AS $$
DECLARE
    cerveja RECORD;
    resposta RECORD;
    cerveja_mais_alinhada INT := 0;
    cerveja_resultado INT := 0;
    questionario_resultado INT;
    usuario_nome VARCHAR;
BEGIN
    -- ValidaÃ§Ã£o de CPF existente
    SELECT nome INTO usuario_nome FROM usuario WHERE cpf = cpf_usuario;
    IF NOT FOUND THEN
        RAISE EXCEPTION 'CPF % nÃ£o encontrado no banco de dados', cpf_usuario;
    END IF;

    -- Loop pelos questionÃ¡rios respondidos pelo usuÃ¡rio
    FOR questionario_resultado IN 
        SELECT DISTINCT r.id_questionario
        FROM resposta_usuario r
        WHERE r.cpf = cpf_usuario
    LOOP
        -- Reinicializa variÃ¡veis para o questionÃ¡rio atual
        cerveja_mais_alinhada := 0;
        cerveja_resultado := 0;

        -- Loop por cada cerveja
        FOR cerveja IN 
            SELECT * FROM cerveja
        LOOP
            DECLARE
                coincidencias INT := 0;
            BEGIN
                -- Loop nas respostas para comparar
                FOR resposta IN 
                    SELECT r2.id_questionario, a.desc_alternativa, a.id_pergunta
                    FROM resposta_usuario r2
                    JOIN alternativa a ON a.id_alternativa = r2.id_alternativa
                    WHERE r2.cpf = cpf_usuario AND r2.id_questionario = questionario_resultado
                LOOP
                    -- ComparaÃ§Ãµes das caracterÃ­sticas
                    IF resposta.id_pergunta = 1 AND cerveja.id_cor = (SELECT id_cor FROM cor WHERE desc_cor = resposta.desc_alternativa) THEN
                        coincidencias := coincidencias + 1;
                    ELSIF resposta.id_pergunta = 2 AND cerveja.id_teor = (SELECT id_teor FROM teor_alcoolico WHERE desc_teor = resposta.desc_alternativa) THEN
                        coincidencias := coincidencias + 1;
                    ELSIF resposta.id_pergunta = 3 AND cerveja.id_amargor = (SELECT id_amargor FROM amargor WHERE desc_amargor = resposta.desc_alternativa) THEN
                        coincidencias := coincidencias + 1;
                    ELSIF resposta.id_pergunta = 4 AND cerveja.id_corpo = (SELECT id_corpo FROM corpo_cerveja WHERE desc_corpo = resposta.desc_alternativa) THEN
                        coincidencias := coincidencias + 1;
                    ELSIF resposta.id_pergunta = 5 AND cerveja.id_aroma = (SELECT id_aroma FROM aroma WHERE desc_aroma = resposta.desc_alternativa) THEN
                        coincidencias := coincidencias + 1;
                    ELSIF resposta.id_pergunta = 6 AND cerveja.id_sabor = (SELECT id_sabor FROM sabor_principal WHERE desc_sabor = resposta.desc_alternativa) THEN
                        coincidencias := coincidencias + 1;
                    ELSIF resposta.id_pergunta = 7 AND cerveja.id_carbonatacao = (SELECT id_carbonatacao FROM carbonatacao WHERE desc_carbona = resposta.desc_alternativa) THEN
                        coincidencias := coincidencias + 1;
                    ELSIF resposta.id_pergunta = 8 AND cerveja.id_mouthfeel = (SELECT id_mouthfeel FROM mouthfeel WHERE desc_mouthfeel = resposta.desc_alternativa) THEN
                        coincidencias := coincidencias + 1;
                    END IF;
                END LOOP;

                -- Atualiza a cerveja mais alinhada
                IF coincidencias > cerveja_mais_alinhada THEN
                    cerveja_mais_alinhada := coincidencias;
                    cerveja_resultado := cerveja.id_cerveja;
                END IF;
            END;
        END LOOP;

        -- Retorna a linha com a recomendaÃ§Ã£o
        cpf_usuario_out := cpf_usuario;
        nome_usuario := usuario_nome;
        id_questionario := questionario_resultado;
        id_cerveja_recomendada := cerveja_resultado;

        RETURN NEXT;
    END LOOP;
END;
$$;
 H   DROP FUNCTION public.recomendar_cerveja(cpf_usuario character varying);
       public          postgres    false            �            1259    18457    alternativa    TABLE     �   CREATE TABLE public.alternativa (
    id_alternativa integer NOT NULL,
    desc_alternativa character varying(255) NOT NULL,
    id_pergunta integer
);
    DROP TABLE public.alternativa;
       public         heap    postgres    false            �            1259    18456    alternativa_id_alternativa_seq    SEQUENCE     �   CREATE SEQUENCE public.alternativa_id_alternativa_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.alternativa_id_alternativa_seq;
       public          postgres    false    245            z           0    0    alternativa_id_alternativa_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.alternativa_id_alternativa_seq OWNED BY public.alternativa.id_alternativa;
          public          postgres    false    244            �            1259    18299    amargor    TABLE     �   CREATE TABLE public.amargor (
    id_amargor integer NOT NULL,
    desc_amargor character varying(50) NOT NULL,
    faixa_ibu character varying(20) NOT NULL
);
    DROP TABLE public.amargor;
       public         heap    postgres    false            �            1259    18298    amargor_id_amargor_seq    SEQUENCE     �   CREATE SEQUENCE public.amargor_id_amargor_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.amargor_id_amargor_seq;
       public          postgres    false    218            {           0    0    amargor_id_amargor_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.amargor_id_amargor_seq OWNED BY public.amargor.id_amargor;
          public          postgres    false    217            �            1259    18320    aroma    TABLE     l   CREATE TABLE public.aroma (
    id_aroma integer NOT NULL,
    desc_aroma character varying(50) NOT NULL
);
    DROP TABLE public.aroma;
       public         heap    postgres    false            �            1259    18319    aroma_id_aroma_seq    SEQUENCE     �   CREATE SEQUENCE public.aroma_id_aroma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.aroma_id_aroma_seq;
       public          postgres    false    224            |           0    0    aroma_id_aroma_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.aroma_id_aroma_seq OWNED BY public.aroma.id_aroma;
          public          postgres    false    223            �            1259    18438 	   auditoria    TABLE     '  CREATE TABLE public.auditoria (
    id_auditoria integer NOT NULL,
    id_login integer,
    campo_alterado character varying(50) NOT NULL,
    valor_antigo character varying(50) NOT NULL,
    valor_novo character varying(50) NOT NULL,
    data_alteracao timestamp without time zone NOT NULL
);
    DROP TABLE public.auditoria;
       public         heap    postgres    false            �            1259    18437    auditoria_id_auditoria_seq    SEQUENCE     �   CREATE SEQUENCE public.auditoria_id_auditoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.auditoria_id_auditoria_seq;
       public          postgres    false    241            }           0    0    auditoria_id_auditoria_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.auditoria_id_auditoria_seq OWNED BY public.auditoria.id_auditoria;
          public          postgres    false    240            �            1259    18334    carbonatacao    TABLE     |   CREATE TABLE public.carbonatacao (
    id_carbonatacao integer NOT NULL,
    desc_carbona character varying(50) NOT NULL
);
     DROP TABLE public.carbonatacao;
       public         heap    postgres    false            �            1259    18333     carbonatacao_id_carbonatacao_seq    SEQUENCE     �   CREATE SEQUENCE public.carbonatacao_id_carbonatacao_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE public.carbonatacao_id_carbonatacao_seq;
       public          postgres    false    228            ~           0    0     carbonatacao_id_carbonatacao_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE public.carbonatacao_id_carbonatacao_seq OWNED BY public.carbonatacao.id_carbonatacao;
          public          postgres    false    227            �            1259    18355    cerveja    TABLE     o  CREATE TABLE public.cerveja (
    id_cerveja integer NOT NULL,
    nome character varying(50) NOT NULL,
    descricao character varying(255) NOT NULL,
    id_cor integer,
    id_amargor integer,
    id_teor integer,
    id_corpo integer,
    id_aroma integer,
    id_sabor integer,
    id_carbonatacao integer,
    id_mouthfeel integer,
    id_img_cerveja integer
);
    DROP TABLE public.cerveja;
       public         heap    postgres    false            �            1259    18354    cerveja_id_cerveja_seq    SEQUENCE     �   CREATE SEQUENCE public.cerveja_id_cerveja_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.cerveja_id_cerveja_seq;
       public          postgres    false    234                       0    0    cerveja_id_cerveja_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.cerveja_id_cerveja_seq OWNED BY public.cerveja.id_cerveja;
          public          postgres    false    233            �            1259    18292    cor    TABLE     �   CREATE TABLE public.cor (
    id_cor integer NOT NULL,
    desc_cor character varying(50) NOT NULL,
    faixa_ebc character varying(20) NOT NULL
);
    DROP TABLE public.cor;
       public         heap    postgres    false            �            1259    18291    cor_id_cor_seq    SEQUENCE     �   CREATE SEQUENCE public.cor_id_cor_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.cor_id_cor_seq;
       public          postgres    false    216            �           0    0    cor_id_cor_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.cor_id_cor_seq OWNED BY public.cor.id_cor;
          public          postgres    false    215            �            1259    18313    corpo_cerveja    TABLE     t   CREATE TABLE public.corpo_cerveja (
    id_corpo integer NOT NULL,
    desc_corpo character varying(50) NOT NULL
);
 !   DROP TABLE public.corpo_cerveja;
       public         heap    postgres    false            �            1259    18312    corpo_cerveja_id_corpo_seq    SEQUENCE     �   CREATE SEQUENCE public.corpo_cerveja_id_corpo_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.corpo_cerveja_id_corpo_seq;
       public          postgres    false    222            �           0    0    corpo_cerveja_id_corpo_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.corpo_cerveja_id_corpo_seq OWNED BY public.corpo_cerveja.id_corpo;
          public          postgres    false    221            �            1259    18407    foto_usuario    TABLE     x   CREATE TABLE public.foto_usuario (
    id_foto_usuario integer NOT NULL,
    img_foto_usuario character varying(255)
);
     DROP TABLE public.foto_usuario;
       public         heap    postgres    false            �            1259    18406     foto_usuario_id_foto_usuario_seq    SEQUENCE     �   CREATE SEQUENCE public.foto_usuario_id_foto_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE public.foto_usuario_id_foto_usuario_seq;
       public          postgres    false    236            �           0    0     foto_usuario_id_foto_usuario_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE public.foto_usuario_id_foto_usuario_seq OWNED BY public.foto_usuario.id_foto_usuario;
          public          postgres    false    235            �            1259    18348    img_cerveja    TABLE     z   CREATE TABLE public.img_cerveja (
    id_img_cerveja integer NOT NULL,
    img_cerveja character varying(255) NOT NULL
);
    DROP TABLE public.img_cerveja;
       public         heap    postgres    false            �            1259    18347    img_cerveja_id_img_cerveja_seq    SEQUENCE     �   CREATE SEQUENCE public.img_cerveja_id_img_cerveja_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.img_cerveja_id_img_cerveja_seq;
       public          postgres    false    232            �           0    0    img_cerveja_id_img_cerveja_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.img_cerveja_id_img_cerveja_seq OWNED BY public.img_cerveja.id_img_cerveja;
          public          postgres    false    231            �            1259    18424    login    TABLE     �   CREATE TABLE public.login (
    id_login integer NOT NULL,
    senha character varying(355) NOT NULL,
    cpf character varying
);
    DROP TABLE public.login;
       public         heap    postgres    false            �            1259    18423    login_id_login_seq    SEQUENCE     �   CREATE SEQUENCE public.login_id_login_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.login_id_login_seq;
       public          postgres    false    239            �           0    0    login_id_login_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.login_id_login_seq OWNED BY public.login.id_login;
          public          postgres    false    238            �            1259    18341 	   mouthfeel    TABLE     x   CREATE TABLE public.mouthfeel (
    id_mouthfeel integer NOT NULL,
    desc_mouthfeel character varying(50) NOT NULL
);
    DROP TABLE public.mouthfeel;
       public         heap    postgres    false            �            1259    18340    mouthfeel_id_mouthfeel_seq    SEQUENCE     �   CREATE SEQUENCE public.mouthfeel_id_mouthfeel_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.mouthfeel_id_mouthfeel_seq;
       public          postgres    false    230            �           0    0    mouthfeel_id_mouthfeel_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.mouthfeel_id_mouthfeel_seq OWNED BY public.mouthfeel.id_mouthfeel;
          public          postgres    false    229            �            1259    18450    pergunta    TABLE     v   CREATE TABLE public.pergunta (
    id_pergunta integer NOT NULL,
    desc_pergunta character varying(255) NOT NULL
);
    DROP TABLE public.pergunta;
       public         heap    postgres    false            �            1259    18449    pergunta_id_pergunta_seq    SEQUENCE     �   CREATE SEQUENCE public.pergunta_id_pergunta_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.pergunta_id_pergunta_seq;
       public          postgres    false    243            �           0    0    pergunta_id_pergunta_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.pergunta_id_pergunta_seq OWNED BY public.pergunta.id_pergunta;
          public          postgres    false    242            �            1259    18505    questionario    TABLE        CREATE TABLE public.questionario (
    id_questionario integer NOT NULL,
    cpf character varying,
    id_resposta integer
);
     DROP TABLE public.questionario;
       public         heap    postgres    false            �            1259    18504     questionario_id_questionario_seq    SEQUENCE     �   CREATE SEQUENCE public.questionario_id_questionario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE public.questionario_id_questionario_seq;
       public          postgres    false    251            �           0    0     questionario_id_questionario_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE public.questionario_id_questionario_seq OWNED BY public.questionario.id_questionario;
          public          postgres    false    250            �            1259    18488    recomendacao    TABLE     �   CREATE TABLE public.recomendacao (
    id_recomendacao integer NOT NULL,
    id_resposta integer,
    id_cerveja integer,
    id_questionario integer
);
     DROP TABLE public.recomendacao;
       public         heap    postgres    false            �            1259    18487     recomendacao_id_recomendacao_seq    SEQUENCE     �   CREATE SEQUENCE public.recomendacao_id_recomendacao_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE public.recomendacao_id_recomendacao_seq;
       public          postgres    false    249            �           0    0     recomendacao_id_recomendacao_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE public.recomendacao_id_recomendacao_seq OWNED BY public.recomendacao.id_recomendacao;
          public          postgres    false    248            �            1259    18469    resposta_usuario    TABLE     �   CREATE TABLE public.resposta_usuario (
    id_resposta integer NOT NULL,
    cpf character varying,
    id_alternativa integer,
    data_preenchimento timestamp without time zone NOT NULL
);
 $   DROP TABLE public.resposta_usuario;
       public         heap    postgres    false            �            1259    18468     resposta_usuario_id_resposta_seq    SEQUENCE     �   CREATE SEQUENCE public.resposta_usuario_id_resposta_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE public.resposta_usuario_id_resposta_seq;
       public          postgres    false    247            �           0    0     resposta_usuario_id_resposta_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE public.resposta_usuario_id_resposta_seq OWNED BY public.resposta_usuario.id_resposta;
          public          postgres    false    246            �            1259    18327    sabor_principal    TABLE     v   CREATE TABLE public.sabor_principal (
    id_sabor integer NOT NULL,
    desc_sabor character varying(50) NOT NULL
);
 #   DROP TABLE public.sabor_principal;
       public         heap    postgres    false            �            1259    18326    sabor_principal_id_sabor_seq    SEQUENCE     �   CREATE SEQUENCE public.sabor_principal_id_sabor_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.sabor_principal_id_sabor_seq;
       public          postgres    false    226            �           0    0    sabor_principal_id_sabor_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.sabor_principal_id_sabor_seq OWNED BY public.sabor_principal.id_sabor;
          public          postgres    false    225            �            1259    18306    teor_alcoolico    TABLE     �   CREATE TABLE public.teor_alcoolico (
    id_teor integer NOT NULL,
    desc_teor character varying(50) NOT NULL,
    faixa_abv character varying(20) NOT NULL
);
 "   DROP TABLE public.teor_alcoolico;
       public         heap    postgres    false            �            1259    18305    teor_alcoolico_id_teor_seq    SEQUENCE     �   CREATE SEQUENCE public.teor_alcoolico_id_teor_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.teor_alcoolico_id_teor_seq;
       public          postgres    false    220            �           0    0    teor_alcoolico_id_teor_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.teor_alcoolico_id_teor_seq OWNED BY public.teor_alcoolico.id_teor;
          public          postgres    false    219            �            1259    18413    usuario    TABLE     �  CREATE TABLE public.usuario (
    cpf character varying(11) NOT NULL,
    nome character varying(50) NOT NULL,
    sobrenome character varying(50) NOT NULL,
    email character varying(100) NOT NULL,
    senha character varying(255) NOT NULL,
    telefone character varying(15),
    data_cadastro timestamp without time zone NOT NULL,
    tipo_usuario integer NOT NULL,
    id_foto_usuario integer
);
    DROP TABLE public.usuario;
       public         heap    postgres    false            �           2604    18460    alternativa id_alternativa    DEFAULT     �   ALTER TABLE ONLY public.alternativa ALTER COLUMN id_alternativa SET DEFAULT nextval('public.alternativa_id_alternativa_seq'::regclass);
 I   ALTER TABLE public.alternativa ALTER COLUMN id_alternativa DROP DEFAULT;
       public          postgres    false    245    244    245            u           2604    18302    amargor id_amargor    DEFAULT     x   ALTER TABLE ONLY public.amargor ALTER COLUMN id_amargor SET DEFAULT nextval('public.amargor_id_amargor_seq'::regclass);
 A   ALTER TABLE public.amargor ALTER COLUMN id_amargor DROP DEFAULT;
       public          postgres    false    218    217    218            x           2604    18323    aroma id_aroma    DEFAULT     p   ALTER TABLE ONLY public.aroma ALTER COLUMN id_aroma SET DEFAULT nextval('public.aroma_id_aroma_seq'::regclass);
 =   ALTER TABLE public.aroma ALTER COLUMN id_aroma DROP DEFAULT;
       public          postgres    false    224    223    224            �           2604    18441    auditoria id_auditoria    DEFAULT     �   ALTER TABLE ONLY public.auditoria ALTER COLUMN id_auditoria SET DEFAULT nextval('public.auditoria_id_auditoria_seq'::regclass);
 E   ALTER TABLE public.auditoria ALTER COLUMN id_auditoria DROP DEFAULT;
       public          postgres    false    240    241    241            z           2604    18337    carbonatacao id_carbonatacao    DEFAULT     �   ALTER TABLE ONLY public.carbonatacao ALTER COLUMN id_carbonatacao SET DEFAULT nextval('public.carbonatacao_id_carbonatacao_seq'::regclass);
 K   ALTER TABLE public.carbonatacao ALTER COLUMN id_carbonatacao DROP DEFAULT;
       public          postgres    false    227    228    228            }           2604    18358    cerveja id_cerveja    DEFAULT     x   ALTER TABLE ONLY public.cerveja ALTER COLUMN id_cerveja SET DEFAULT nextval('public.cerveja_id_cerveja_seq'::regclass);
 A   ALTER TABLE public.cerveja ALTER COLUMN id_cerveja DROP DEFAULT;
       public          postgres    false    233    234    234            t           2604    18295 
   cor id_cor    DEFAULT     h   ALTER TABLE ONLY public.cor ALTER COLUMN id_cor SET DEFAULT nextval('public.cor_id_cor_seq'::regclass);
 9   ALTER TABLE public.cor ALTER COLUMN id_cor DROP DEFAULT;
       public          postgres    false    215    216    216            w           2604    18316    corpo_cerveja id_corpo    DEFAULT     �   ALTER TABLE ONLY public.corpo_cerveja ALTER COLUMN id_corpo SET DEFAULT nextval('public.corpo_cerveja_id_corpo_seq'::regclass);
 E   ALTER TABLE public.corpo_cerveja ALTER COLUMN id_corpo DROP DEFAULT;
       public          postgres    false    222    221    222            ~           2604    18410    foto_usuario id_foto_usuario    DEFAULT     �   ALTER TABLE ONLY public.foto_usuario ALTER COLUMN id_foto_usuario SET DEFAULT nextval('public.foto_usuario_id_foto_usuario_seq'::regclass);
 K   ALTER TABLE public.foto_usuario ALTER COLUMN id_foto_usuario DROP DEFAULT;
       public          postgres    false    235    236    236            |           2604    18351    img_cerveja id_img_cerveja    DEFAULT     �   ALTER TABLE ONLY public.img_cerveja ALTER COLUMN id_img_cerveja SET DEFAULT nextval('public.img_cerveja_id_img_cerveja_seq'::regclass);
 I   ALTER TABLE public.img_cerveja ALTER COLUMN id_img_cerveja DROP DEFAULT;
       public          postgres    false    231    232    232                       2604    18427    login id_login    DEFAULT     p   ALTER TABLE ONLY public.login ALTER COLUMN id_login SET DEFAULT nextval('public.login_id_login_seq'::regclass);
 =   ALTER TABLE public.login ALTER COLUMN id_login DROP DEFAULT;
       public          postgres    false    238    239    239            {           2604    18344    mouthfeel id_mouthfeel    DEFAULT     �   ALTER TABLE ONLY public.mouthfeel ALTER COLUMN id_mouthfeel SET DEFAULT nextval('public.mouthfeel_id_mouthfeel_seq'::regclass);
 E   ALTER TABLE public.mouthfeel ALTER COLUMN id_mouthfeel DROP DEFAULT;
       public          postgres    false    229    230    230            �           2604    18453    pergunta id_pergunta    DEFAULT     |   ALTER TABLE ONLY public.pergunta ALTER COLUMN id_pergunta SET DEFAULT nextval('public.pergunta_id_pergunta_seq'::regclass);
 C   ALTER TABLE public.pergunta ALTER COLUMN id_pergunta DROP DEFAULT;
       public          postgres    false    243    242    243            �           2604    18508    questionario id_questionario    DEFAULT     �   ALTER TABLE ONLY public.questionario ALTER COLUMN id_questionario SET DEFAULT nextval('public.questionario_id_questionario_seq'::regclass);
 K   ALTER TABLE public.questionario ALTER COLUMN id_questionario DROP DEFAULT;
       public          postgres    false    250    251    251            �           2604    18491    recomendacao id_recomendacao    DEFAULT     �   ALTER TABLE ONLY public.recomendacao ALTER COLUMN id_recomendacao SET DEFAULT nextval('public.recomendacao_id_recomendacao_seq'::regclass);
 K   ALTER TABLE public.recomendacao ALTER COLUMN id_recomendacao DROP DEFAULT;
       public          postgres    false    248    249    249            �           2604    18472    resposta_usuario id_resposta    DEFAULT     �   ALTER TABLE ONLY public.resposta_usuario ALTER COLUMN id_resposta SET DEFAULT nextval('public.resposta_usuario_id_resposta_seq'::regclass);
 K   ALTER TABLE public.resposta_usuario ALTER COLUMN id_resposta DROP DEFAULT;
       public          postgres    false    246    247    247            y           2604    18330    sabor_principal id_sabor    DEFAULT     �   ALTER TABLE ONLY public.sabor_principal ALTER COLUMN id_sabor SET DEFAULT nextval('public.sabor_principal_id_sabor_seq'::regclass);
 G   ALTER TABLE public.sabor_principal ALTER COLUMN id_sabor DROP DEFAULT;
       public          postgres    false    225    226    226            v           2604    18309    teor_alcoolico id_teor    DEFAULT     �   ALTER TABLE ONLY public.teor_alcoolico ALTER COLUMN id_teor SET DEFAULT nextval('public.teor_alcoolico_id_teor_seq'::regclass);
 E   ALTER TABLE public.teor_alcoolico ALTER COLUMN id_teor DROP DEFAULT;
       public          postgres    false    220    219    220            m          0    18457    alternativa 
   TABLE DATA           T   COPY public.alternativa (id_alternativa, desc_alternativa, id_pergunta) FROM stdin;
    public          postgres    false    245   �       R          0    18299    amargor 
   TABLE DATA           F   COPY public.amargor (id_amargor, desc_amargor, faixa_ibu) FROM stdin;
    public          postgres    false    218   �       X          0    18320    aroma 
   TABLE DATA           5   COPY public.aroma (id_aroma, desc_aroma) FROM stdin;
    public          postgres    false    224   u�       i          0    18438 	   auditoria 
   TABLE DATA           u   COPY public.auditoria (id_auditoria, id_login, campo_alterado, valor_antigo, valor_novo, data_alteracao) FROM stdin;
    public          postgres    false    241   ��       \          0    18334    carbonatacao 
   TABLE DATA           E   COPY public.carbonatacao (id_carbonatacao, desc_carbona) FROM stdin;
    public          postgres    false    228   ��       b          0    18355    cerveja 
   TABLE DATA           �   COPY public.cerveja (id_cerveja, nome, descricao, id_cor, id_amargor, id_teor, id_corpo, id_aroma, id_sabor, id_carbonatacao, id_mouthfeel, id_img_cerveja) FROM stdin;
    public          postgres    false    234   �       P          0    18292    cor 
   TABLE DATA           :   COPY public.cor (id_cor, desc_cor, faixa_ebc) FROM stdin;
    public          postgres    false    216   7�       V          0    18313    corpo_cerveja 
   TABLE DATA           =   COPY public.corpo_cerveja (id_corpo, desc_corpo) FROM stdin;
    public          postgres    false    222   ��       d          0    18407    foto_usuario 
   TABLE DATA           I   COPY public.foto_usuario (id_foto_usuario, img_foto_usuario) FROM stdin;
    public          postgres    false    236   ��       `          0    18348    img_cerveja 
   TABLE DATA           B   COPY public.img_cerveja (id_img_cerveja, img_cerveja) FROM stdin;
    public          postgres    false    232   ^�       g          0    18424    login 
   TABLE DATA           5   COPY public.login (id_login, senha, cpf) FROM stdin;
    public          postgres    false    239   {�       ^          0    18341 	   mouthfeel 
   TABLE DATA           A   COPY public.mouthfeel (id_mouthfeel, desc_mouthfeel) FROM stdin;
    public          postgres    false    230   ��       k          0    18450    pergunta 
   TABLE DATA           >   COPY public.pergunta (id_pergunta, desc_pergunta) FROM stdin;
    public          postgres    false    243   ��       s          0    18505    questionario 
   TABLE DATA           I   COPY public.questionario (id_questionario, cpf, id_resposta) FROM stdin;
    public          postgres    false    251   ��       q          0    18488    recomendacao 
   TABLE DATA           a   COPY public.recomendacao (id_recomendacao, id_resposta, id_cerveja, id_questionario) FROM stdin;
    public          postgres    false    249   ��       o          0    18469    resposta_usuario 
   TABLE DATA           `   COPY public.resposta_usuario (id_resposta, cpf, id_alternativa, data_preenchimento) FROM stdin;
    public          postgres    false    247   �       Z          0    18327    sabor_principal 
   TABLE DATA           ?   COPY public.sabor_principal (id_sabor, desc_sabor) FROM stdin;
    public          postgres    false    226   -�       T          0    18306    teor_alcoolico 
   TABLE DATA           G   COPY public.teor_alcoolico (id_teor, desc_teor, faixa_abv) FROM stdin;
    public          postgres    false    220   l�       e          0    18413    usuario 
   TABLE DATA           }   COPY public.usuario (cpf, nome, sobrenome, email, senha, telefone, data_cadastro, tipo_usuario, id_foto_usuario) FROM stdin;
    public          postgres    false    237   ��       �           0    0    alternativa_id_alternativa_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.alternativa_id_alternativa_seq', 1, false);
          public          postgres    false    244            �           0    0    amargor_id_amargor_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.amargor_id_amargor_seq', 4, true);
          public          postgres    false    217            �           0    0    aroma_id_aroma_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.aroma_id_aroma_seq', 5, true);
          public          postgres    false    223            �           0    0    auditoria_id_auditoria_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.auditoria_id_auditoria_seq', 1, false);
          public          postgres    false    240            �           0    0     carbonatacao_id_carbonatacao_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.carbonatacao_id_carbonatacao_seq', 3, true);
          public          postgres    false    227            �           0    0    cerveja_id_cerveja_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.cerveja_id_cerveja_seq', 1, false);
          public          postgres    false    233            �           0    0    cor_id_cor_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.cor_id_cor_seq', 6, true);
          public          postgres    false    215            �           0    0    corpo_cerveja_id_corpo_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.corpo_cerveja_id_corpo_seq', 3, true);
          public          postgres    false    221            �           0    0     foto_usuario_id_foto_usuario_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.foto_usuario_id_foto_usuario_seq', 2, true);
          public          postgres    false    235            �           0    0    img_cerveja_id_img_cerveja_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.img_cerveja_id_img_cerveja_seq', 1, false);
          public          postgres    false    231            �           0    0    login_id_login_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.login_id_login_seq', 1, false);
          public          postgres    false    238            �           0    0    mouthfeel_id_mouthfeel_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.mouthfeel_id_mouthfeel_seq', 5, true);
          public          postgres    false    229            �           0    0    pergunta_id_pergunta_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.pergunta_id_pergunta_seq', 1, false);
          public          postgres    false    242            �           0    0     questionario_id_questionario_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.questionario_id_questionario_seq', 3, true);
          public          postgres    false    250            �           0    0     recomendacao_id_recomendacao_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('public.recomendacao_id_recomendacao_seq', 1, false);
          public          postgres    false    248            �           0    0     resposta_usuario_id_resposta_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('public.resposta_usuario_id_resposta_seq', 1, false);
          public          postgres    false    246            �           0    0    sabor_principal_id_sabor_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.sabor_principal_id_sabor_seq', 4, true);
          public          postgres    false    225            �           0    0    teor_alcoolico_id_teor_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.teor_alcoolico_id_teor_seq', 4, true);
          public          postgres    false    219            �           2606    18462    alternativa alternativa_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.alternativa
    ADD CONSTRAINT alternativa_pkey PRIMARY KEY (id_alternativa);
 F   ALTER TABLE ONLY public.alternativa DROP CONSTRAINT alternativa_pkey;
       public            postgres    false    245            �           2606    18304    amargor amargor_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.amargor
    ADD CONSTRAINT amargor_pkey PRIMARY KEY (id_amargor);
 >   ALTER TABLE ONLY public.amargor DROP CONSTRAINT amargor_pkey;
       public            postgres    false    218            �           2606    18325    aroma aroma_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.aroma
    ADD CONSTRAINT aroma_pkey PRIMARY KEY (id_aroma);
 :   ALTER TABLE ONLY public.aroma DROP CONSTRAINT aroma_pkey;
       public            postgres    false    224            �           2606    18443    auditoria auditoria_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.auditoria
    ADD CONSTRAINT auditoria_pkey PRIMARY KEY (id_auditoria);
 B   ALTER TABLE ONLY public.auditoria DROP CONSTRAINT auditoria_pkey;
       public            postgres    false    241            �           2606    18339    carbonatacao carbonatacao_pkey 
   CONSTRAINT     i   ALTER TABLE ONLY public.carbonatacao
    ADD CONSTRAINT carbonatacao_pkey PRIMARY KEY (id_carbonatacao);
 H   ALTER TABLE ONLY public.carbonatacao DROP CONSTRAINT carbonatacao_pkey;
       public            postgres    false    228            �           2606    18360    cerveja cerveja_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_pkey PRIMARY KEY (id_cerveja);
 >   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_pkey;
       public            postgres    false    234            �           2606    18297    cor cor_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.cor
    ADD CONSTRAINT cor_pkey PRIMARY KEY (id_cor);
 6   ALTER TABLE ONLY public.cor DROP CONSTRAINT cor_pkey;
       public            postgres    false    216            �           2606    18318     corpo_cerveja corpo_cerveja_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.corpo_cerveja
    ADD CONSTRAINT corpo_cerveja_pkey PRIMARY KEY (id_corpo);
 J   ALTER TABLE ONLY public.corpo_cerveja DROP CONSTRAINT corpo_cerveja_pkey;
       public            postgres    false    222            �           2606    18412    foto_usuario foto_usuario_pkey 
   CONSTRAINT     i   ALTER TABLE ONLY public.foto_usuario
    ADD CONSTRAINT foto_usuario_pkey PRIMARY KEY (id_foto_usuario);
 H   ALTER TABLE ONLY public.foto_usuario DROP CONSTRAINT foto_usuario_pkey;
       public            postgres    false    236            �           2606    18353    img_cerveja img_cerveja_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.img_cerveja
    ADD CONSTRAINT img_cerveja_pkey PRIMARY KEY (id_img_cerveja);
 F   ALTER TABLE ONLY public.img_cerveja DROP CONSTRAINT img_cerveja_pkey;
       public            postgres    false    232            �           2606    18431    login login_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.login
    ADD CONSTRAINT login_pkey PRIMARY KEY (id_login);
 :   ALTER TABLE ONLY public.login DROP CONSTRAINT login_pkey;
       public            postgres    false    239            �           2606    18346    mouthfeel mouthfeel_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.mouthfeel
    ADD CONSTRAINT mouthfeel_pkey PRIMARY KEY (id_mouthfeel);
 B   ALTER TABLE ONLY public.mouthfeel DROP CONSTRAINT mouthfeel_pkey;
       public            postgres    false    230            �           2606    18455    pergunta pergunta_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public.pergunta
    ADD CONSTRAINT pergunta_pkey PRIMARY KEY (id_pergunta);
 @   ALTER TABLE ONLY public.pergunta DROP CONSTRAINT pergunta_pkey;
       public            postgres    false    243            �           2606    18512    questionario questionario_pkey 
   CONSTRAINT     i   ALTER TABLE ONLY public.questionario
    ADD CONSTRAINT questionario_pkey PRIMARY KEY (id_questionario);
 H   ALTER TABLE ONLY public.questionario DROP CONSTRAINT questionario_pkey;
       public            postgres    false    251            �           2606    18493    recomendacao recomendacao_pkey 
   CONSTRAINT     i   ALTER TABLE ONLY public.recomendacao
    ADD CONSTRAINT recomendacao_pkey PRIMARY KEY (id_recomendacao);
 H   ALTER TABLE ONLY public.recomendacao DROP CONSTRAINT recomendacao_pkey;
       public            postgres    false    249            �           2606    18476 &   resposta_usuario resposta_usuario_pkey 
   CONSTRAINT     m   ALTER TABLE ONLY public.resposta_usuario
    ADD CONSTRAINT resposta_usuario_pkey PRIMARY KEY (id_resposta);
 P   ALTER TABLE ONLY public.resposta_usuario DROP CONSTRAINT resposta_usuario_pkey;
       public            postgres    false    247            �           2606    18332 $   sabor_principal sabor_principal_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.sabor_principal
    ADD CONSTRAINT sabor_principal_pkey PRIMARY KEY (id_sabor);
 N   ALTER TABLE ONLY public.sabor_principal DROP CONSTRAINT sabor_principal_pkey;
       public            postgres    false    226            �           2606    18311 "   teor_alcoolico teor_alcoolico_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY public.teor_alcoolico
    ADD CONSTRAINT teor_alcoolico_pkey PRIMARY KEY (id_teor);
 L   ALTER TABLE ONLY public.teor_alcoolico DROP CONSTRAINT teor_alcoolico_pkey;
       public            postgres    false    220            �           2606    18417    usuario usuario_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (cpf);
 >   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_pkey;
       public            postgres    false    237            �           2606    18463 (   alternativa alternativa_id_pergunta_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.alternativa
    ADD CONSTRAINT alternativa_id_pergunta_fkey FOREIGN KEY (id_pergunta) REFERENCES public.pergunta(id_pergunta);
 R   ALTER TABLE ONLY public.alternativa DROP CONSTRAINT alternativa_id_pergunta_fkey;
       public          postgres    false    243    4771    245            �           2606    18444 !   auditoria auditoria_id_login_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.auditoria
    ADD CONSTRAINT auditoria_id_login_fkey FOREIGN KEY (id_login) REFERENCES public.login(id_login);
 K   ALTER TABLE ONLY public.auditoria DROP CONSTRAINT auditoria_id_login_fkey;
       public          postgres    false    239    241    4767            �           2606    18366    cerveja cerveja_id_amargor_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_id_amargor_fkey FOREIGN KEY (id_amargor) REFERENCES public.amargor(id_amargor);
 I   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_id_amargor_fkey;
       public          postgres    false    4745    234    218            �           2606    18381    cerveja cerveja_id_aroma_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_id_aroma_fkey FOREIGN KEY (id_aroma) REFERENCES public.aroma(id_aroma);
 G   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_id_aroma_fkey;
       public          postgres    false    224    234    4751            �           2606    18391 $   cerveja cerveja_id_carbonatacao_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_id_carbonatacao_fkey FOREIGN KEY (id_carbonatacao) REFERENCES public.carbonatacao(id_carbonatacao);
 N   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_id_carbonatacao_fkey;
       public          postgres    false    228    234    4755            �           2606    18361    cerveja cerveja_id_cor_fkey    FK CONSTRAINT     {   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_id_cor_fkey FOREIGN KEY (id_cor) REFERENCES public.cor(id_cor);
 E   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_id_cor_fkey;
       public          postgres    false    234    4743    216            �           2606    18376    cerveja cerveja_id_corpo_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_id_corpo_fkey FOREIGN KEY (id_corpo) REFERENCES public.corpo_cerveja(id_corpo);
 G   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_id_corpo_fkey;
       public          postgres    false    234    222    4749            �           2606    18401 #   cerveja cerveja_id_img_cerveja_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_id_img_cerveja_fkey FOREIGN KEY (id_img_cerveja) REFERENCES public.img_cerveja(id_img_cerveja);
 M   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_id_img_cerveja_fkey;
       public          postgres    false    234    4759    232            �           2606    18396 !   cerveja cerveja_id_mouthfeel_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_id_mouthfeel_fkey FOREIGN KEY (id_mouthfeel) REFERENCES public.mouthfeel(id_mouthfeel);
 K   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_id_mouthfeel_fkey;
       public          postgres    false    234    230    4757            �           2606    18386    cerveja cerveja_id_sabor_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_id_sabor_fkey FOREIGN KEY (id_sabor) REFERENCES public.sabor_principal(id_sabor);
 G   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_id_sabor_fkey;
       public          postgres    false    226    4753    234            �           2606    18371    cerveja cerveja_id_teor_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cerveja
    ADD CONSTRAINT cerveja_id_teor_fkey FOREIGN KEY (id_teor) REFERENCES public.teor_alcoolico(id_teor);
 F   ALTER TABLE ONLY public.cerveja DROP CONSTRAINT cerveja_id_teor_fkey;
       public          postgres    false    220    4747    234            �           2606    18525    recomendacao fk_id_questionario    FK CONSTRAINT     �   ALTER TABLE ONLY public.recomendacao
    ADD CONSTRAINT fk_id_questionario FOREIGN KEY (id_questionario) REFERENCES public.questionario(id_questionario);
 I   ALTER TABLE ONLY public.recomendacao DROP CONSTRAINT fk_id_questionario;
       public          postgres    false    251    249    4779            �           2606    18432    login login_cpf_fkey    FK CONSTRAINT     r   ALTER TABLE ONLY public.login
    ADD CONSTRAINT login_cpf_fkey FOREIGN KEY (cpf) REFERENCES public.usuario(cpf);
 >   ALTER TABLE ONLY public.login DROP CONSTRAINT login_cpf_fkey;
       public          postgres    false    4765    239    237            �           2606    18513 "   questionario questionario_cpf_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.questionario
    ADD CONSTRAINT questionario_cpf_fkey FOREIGN KEY (cpf) REFERENCES public.usuario(cpf);
 L   ALTER TABLE ONLY public.questionario DROP CONSTRAINT questionario_cpf_fkey;
       public          postgres    false    237    251    4765            �           2606    18518 *   questionario questionario_id_resposta_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.questionario
    ADD CONSTRAINT questionario_id_resposta_fkey FOREIGN KEY (id_resposta) REFERENCES public.resposta_usuario(id_resposta);
 T   ALTER TABLE ONLY public.questionario DROP CONSTRAINT questionario_id_resposta_fkey;
       public          postgres    false    251    247    4775            �           2606    18499 )   recomendacao recomendacao_id_cerveja_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.recomendacao
    ADD CONSTRAINT recomendacao_id_cerveja_fkey FOREIGN KEY (id_cerveja) REFERENCES public.cerveja(id_cerveja);
 S   ALTER TABLE ONLY public.recomendacao DROP CONSTRAINT recomendacao_id_cerveja_fkey;
       public          postgres    false    234    4761    249            �           2606    18494 *   recomendacao recomendacao_id_resposta_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.recomendacao
    ADD CONSTRAINT recomendacao_id_resposta_fkey FOREIGN KEY (id_resposta) REFERENCES public.resposta_usuario(id_resposta);
 T   ALTER TABLE ONLY public.recomendacao DROP CONSTRAINT recomendacao_id_resposta_fkey;
       public          postgres    false    247    249    4775            �           2606    18477 *   resposta_usuario resposta_usuario_cpf_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.resposta_usuario
    ADD CONSTRAINT resposta_usuario_cpf_fkey FOREIGN KEY (cpf) REFERENCES public.usuario(cpf);
 T   ALTER TABLE ONLY public.resposta_usuario DROP CONSTRAINT resposta_usuario_cpf_fkey;
       public          postgres    false    237    4765    247            �           2606    18482 5   resposta_usuario resposta_usuario_id_alternativa_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.resposta_usuario
    ADD CONSTRAINT resposta_usuario_id_alternativa_fkey FOREIGN KEY (id_alternativa) REFERENCES public.alternativa(id_alternativa);
 _   ALTER TABLE ONLY public.resposta_usuario DROP CONSTRAINT resposta_usuario_id_alternativa_fkey;
       public          postgres    false    4773    245    247            �           2606    18418 $   usuario usuario_id_foto_usuario_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_id_foto_usuario_fkey FOREIGN KEY (id_foto_usuario) REFERENCES public.foto_usuario(id_foto_usuario);
 N   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_id_foto_usuario_fkey;
       public          postgres    false    236    237    4763            m     x�E�Mn� F���	� ��ܥ�	L"$�`[�N��9r�V��{��1.��2�y�-�?�LRq��g�J#��Tq�]xi�G�)<2�����ڠ�	�����%�\#�ưJ���jT�_;��wdܫ�'����|sY�E�Y�&��'\b���\��I��K�3���H��zǘ�^U��v�w�P(^i�����2�t�hd(+��ge5�p�%x�=`P��F|aٸ8�-����8��M��קR��w�      R   R   x�3��I-K�4P�U02P�t
�2���OI-JL��42
�@��9s���9M@�fA���̒|��H���@,���� z�      X   A   x�3�L+*-IL��2�L��/J��2�L-.HM�L,�L,�2�,�/*)0�LN,J�M������� :D      i      x������ � �      \   '   x�3�LJ̬H�2���OI-JLI�2�L�)I����� ��\      b      x������ � �      P   b   x�%Ƚ	�0����rb~�Vq���3D]�U\L��{�����e���^n�1�6�,�'GhK��r�J�Ȏu<2��ד�+��t1B�V��R�U	�      V   )   x�3��I-K�2��=�2%3�˘35/9�� 1%�+F��� �v	�      d   l   x�3����/-N-
-��OL)�7476612��4�MN-*��O�+�K�2¡��.<#��ر�@�371=U����D��\��L!�D�P��L��R!�WA�PS/� 5�+F��� ��!m      `      x������ � �      g      x������ � �      ^   C   x�3�,.M,K�2�L.J��/�LILI�2�,NM��2�LMK-*K-NN�+I�2���)������� _^	      k   �   x�u�;1Dkr
�� ���4ެ��$^9�^��D�r1�G�E��dϼ:�z@�,P� ih�3|�j�#z����n��1�|m�CI�e��w�����d��j��͜<�.A�ӓ(*���� ~����	�Q���U��;d�yP�(G�1���e����(��C�l���nC�{��c�\8      s   $   x�3�4031340414�����2B0F����� &T
$      q      x������ � �      o      x������ � �      Z   /   x�3�L�ON�2�L�M,J��2�<�093%�˄�81'=Ȋ���� ��      T   T   x�3�LJ̬��L,9�R�X�T�ˈ37?%�(1%��X�LU!Q�$l̙�S��i
2	�p�f��+�%�3sRR!R1z\\\ �U�      e   �   x�M���@�뽧����]T*�L����S/	(�����L�d&3������܌����}��k��W�頨�+��.S~��\3���g�s���z�}�l\̜45�����N��~W�kFz�V�A��Z�C�k��* 0�(�yS,�w0M3����tگ��{��kT�G���<jq�B��HF     