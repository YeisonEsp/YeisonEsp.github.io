-- A CONTINUACION SE REALIZA EL DDL DE LAS TABLAS PARA EL PROYECTO AMAROK --
-- 
DROP TABLE IF EXISTS detallepedido;
DROP TABLE IF EXISTS pedidoproveedor;
DROP TABLE IF EXISTS envio;
DROP TABLE IF EXISTS empresatransporte;
DROP TABLE IF EXISTS redencionpuntos;
DROP TABLE IF EXISTS detalleventa;
DROP TABLE IF EXISTS venta;
DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS cliente;
DROP TABLE IF EXISTS producto;
DROP TABLE IF EXISTS seccion;
DROP TABLE IF EXISTS bandeja;
DROP TABLE IF EXISTS estante;
DROP TABLE IF EXISTS marca;
DROP TABLE IF EXISTS linea;
DROP TABLE IF EXISTS tipoproducto;
DROP TABLE IF EXISTS proveedor;
DROP TABLE IF EXISTS tipopago;
DROP TABLE IF EXISTS ciudad;
DROP TABLE IF EXISTS departamento;
DROP TABLE IF EXISTS contactenos;
DROP TABLE IF EXISTS parametros;

-- TABLA DE PARAMETROS
CREATE TABLE parametros
(
    empreNit          VARCHAR(10) NOT NULL,                             -- NIT DE LA EMPRESA AMAROK
    empreNom          VARCHAR(50) NOT NULL,                             -- NOMBRE DE LA EMPRESA AMAROK
    empreDir          VARCHAR(80) NOT NULL,                             -- DIRECCIÓN DE LA EMPRESA AMAROK
    empreTel          VARCHAR(10) NOT NULL,                             -- TELÉFONO FIJO DE LA EMPRESA AMAROK
    empreCel          VARCHAR(10) NOT NULL,                             -- CELULAR DE LA EMPRESA AMAROK
    empreEma          VARCHAR(50) NOT NULL,                             -- CORREO DE LA EMPRESA AMAROK
    numFacIni         DECIMAL(5,0) NOT NULL,                            -- NÚMERO INICIAL RANGO DE LA FACTURA
    numFacFin         DECIMAL(5,0) NOT NULL,                            -- NÚMERO FINAL RANGO DE LA FACTURA
    numFacFal         DECIMAL(5,0) NOT NULL,                            -- NÚMERO DE FACTURA FALSO DE LA FACTURA PARA PEDIDO DE CLIENTE
    porcenIva         DECIMAL(2,0) NOT NULL,                            -- PORCENTAJE DEL VALOR DEL IVA ACTUAL EN COLOMBIA
    redPunDes         DECIMAL(4,0) NOT NULL,                            -- PUNTAJE MÍNIMO NECESARIO PARA REDIMIR UN DESCUENTO DEL 30%
    redPunDom         DECIMAL(4,0) NOT NULL,                            -- PUNTAJE MÍNIMO NECESARIO PARA REDIMIR UN DOMICILIO GRATIS
    adminCon          VARCHAR(300) NOT NULL,                            -- CONTRASEÑA DEL ADMIN
    tiempoSalir       DECIMAL(2,0) NOT NULL,                            -- TIEMPO PARA CERRAR LA SESIÓN AUTOMÁTICAMENTE(MINUTOS)
    sesionActiva      BOOLEAN NOT NULL DEFAULT FALSE,                   -- INDICADOR DE SESIÓN ACTIVA DEL ADMIN
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY(empreNit)
);

-- TABLA DE EXCEPCIONES
CREATE TABLE excepciones
(
    excepCod        VARCHAR(5) NOT NULL,                                -- CÓDIGO IDENTIFICADOR DE LA EXCEPCIÓN
    excepNom        VARCHAR(100) NOT NULL,                               -- NOMBRE DE LA EXCEPCIÓN
    PRIMARY KEY (excepCod)
);

-- TABLA DE CONTACTENOS
CREATE TABLE contactenos
(                                                                         
    contacId            DECIMAL(9,0) NOT NULL,                          -- NÚMERO IDENTIFICADOR DEL CONTACTO
    contacNom           VARCHAR(60) NOT NULL,                           -- NOMBRE DE LA EMPRESA QUE CONTACTA
    contacTel           VARCHAR(10) NOT NULL,                           -- TELÉFONO DE LA EMPRESA QUE CONTACTA
    contacEma           VARCHAR(50) NOT NULL,                           -- CORREO DE LA EMPRESA QUE CONTACTA
    contacAsu           VARCHAR(200) NOT NULL,                          -- ASUNTO DE LA EMPRESA QUE CONTACTA
    contacRev           BOOLEAN NOT NULL DEFAULT FALSE,                 -- INDICADOR DE SI UN MENSAJE FUE REVISADO O NO
    fec_insert          TIMESTAMP NOT NULL DEFAULT NOW(),               -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO          
    PRIMARY KEY(contacId)
);

-- TABLA DE DEPARTAMENTOS
CREATE TABLE departamento
(
    departId        DECIMAL(2,0) NOT NULL,                              -- NÚMERO IDENTIFICADOR DEL DEPARTAMENTO
    departNom       VARCHAR(40) NOT NULL,                               -- NOMBRE DEL DEPARTAMENTO
    PRIMARY KEY (departId)
);

-- TABLA DE CIUDADES
CREATE TABLE ciudad
(
    ciudadId           DECIMAL(5,0) NOT NULL,                           -- NÚMERO IDENTIFICADOR DE LA CIUDAD
    idDepart           DECIMAL(2,0) NOT NULL,                           -- FORÁNEA DEPARTAMENTO
    ciudadNom          VARCHAR(40) NOT NULL,                            -- NOMBRE DE LA CIUDAD, SOLO SE PUEDE INCLUIR FLORIDABLANCA, GIRÓN, NORTE Y PIEDECUESTA COMO CIUDADES
    precioDom          DECIMAL(5,0) NOT NULL DEFAULT 0,                 -- PRECIO QUE TENDRÁ EL DOMICILIO EN BUCARAMANGA O SU ÁREA METROPOLITANA
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (ciudadId),
    FOREIGN KEY (idDepart) REFERENCES departamento(departId)
);


-- TABLA DE PROVEEDORES
CREATE TABLE proveedor
(
    proveeNit          VARCHAR(10) NOT NULL,                            -- NIT DEL PROVEEDOR
    idCiudad           DECIMAL(5,0) NOT NULL,                           -- FORÁNEA CÓDIGO CIUDAD 
    proveeNom          VARCHAR(40) NOT NULL,                            -- NOMBRE DEL PROVEEDOR
    proveeDir          VARCHAR(80) NOT NULL,                            -- DIRECCIÓN DEL PROVEEDOR
    proveeTel          VARCHAR(10) NOT NULL,                            -- TELÉFONO DEL PROVEEDOR
    proveeEma          VARCHAR(50) NOT NULL,                            -- CORREO/EMAIL DEL PROVEEDOR
    proveeAct          BOOLEAN NOT NULL DEFAULT TRUE,                   -- INDICADOR DE PROVEEDOR ACTIVO TRUE O NO ACTIVO FALSE
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (proveeNit),
    FOREIGN KEY (idCiudad) REFERENCES ciudad(ciudadId)
);


-- TABLA DE TIPOS DE PRODUCTOS
create table tipoproducto(
	tipoProId          DECIMAL(2,0) NOT NULL,                           -- NÚMERO IDENTIFICADOR DEL TIPO DE PRODUCTO
    tipoProNom         VARCHAR(30) NOT NULL,                            -- NOMBRE DEL TIPO DE PRODUCTO
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY(tipoProId)
);


-- TABLA DE LÍNEAS DE PRODUCTOS
create table linea(
	lineaId            DECIMAL(2,0) NOT NULL,                           -- NÚMERO IDENTIFICADOR DE LA LÍNEA
    lineaNom           VARCHAR(30) NOT NULL,                            -- NOMBRE DE LA LÍNEA
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY(lineaId)
);


-- TABLA DE MARCAS DE PRODUCTOS
create table marca(
	marcaId            DECIMAL(3,0) NOT NULL,                           -- NÚMERO IDENTIFICADOR DE LA MARCA
    marcaNom           VARCHAR(30) NOT NULL,                            -- NOMBRE DE LA MARCA
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY(marcaId)
);


-- TABLA DE ESTANTES PARA PRODUCTOS
create table estante(
    estantNom VARCHAR(2) NOT NULL,                                      -- NOMBRE DEL ESTANTE, DEBE SER UNA LETRA
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY(estantNom)
);

-- TABLA DE BANDEJA PARA PRODUCTOS
create table bandeja(                                   
    nomEstant  VARCHAR(2) NOT NULL,                                     -- FORÁNEA ESTANTE
    bandejaNum DECIMAL(2,0) NOT NULL,                                   -- NÚMERO DE LA BANDEJA
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY(nomEstant, bandejaNum),
    FOREIGN KEY (nomEstant) REFERENCES estante(estantNom)
);

-- TABLA DE SECCIONES PARA PRODUCTOS
create table seccion(
    nomEstant  VARCHAR(2) NOT NULL,                                     -- FORÁNEA ESTANTE
    numBandeja DECIMAL(2,0) NOT NULL,                                   -- FORÁNEA BANDEJA
    seccionCod VARCHAR(5) NOT NULL,                                     -- CÓDIGO DE LA SECCIÓN, DEBE SER UNA LETRA
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY(nomEstant, numBandeja, seccionCod),
    FOREIGN KEY (nomEstant, numBandeja) REFERENCES bandeja(nomEstant, bandejaNum)
);

-- TABLA DE PRODUCTOS
CREATE TABLE producto
(
    producCod          VARCHAR(30) NOT NULL,                            -- CÓDIGO IDENTIFICADOR DEL PRODUCTO
    idTipoPro          DECIMAL(2,0) NOT NULL,                           -- FORÁNEA TIPO DE PRODUCTO
    idLinea            DECIMAL(2,0) NOT NULL,                           -- FORÁNEA LÍNEA
    idMarca            DECIMAL(3,0) NOT NULL,                           -- FORÁNEA MARCA
    nomEstant          VARCHAR(2),                                      -- FORÁNEA ESTANTE
    numBandeja         DECIMAL(2,0),                                    -- FORÁNEA BANDEJA
    codSeccion         VARCHAR(5),                                      -- FORÁNEA SECCIÓN
    producNom          VARCHAR(200) NOT NULL,                           -- NOMBRE DEL PRODUCTO
    producMod          VARCHAR(20) NOT NULL,                            -- MODELOS PARA LOS QUE SIRVE EL PRODUCTO
    producSto          DECIMAL(3,0) NOT NULL CHECK(producSto>=0),       -- NUMERO DE PRODUCTOS EN INVENTARIO / STOCK
    producPre          DECIMAL(8,0),                                    -- VALOR UNITARIO PARA VENTA DEL PRODUCTO
    producBod          BOOLEAN NOT NULL DEFAULT TRUE,                   -- INDICADOR DE PRODUCTO EN BODEGA PRINCIPAL
    producEst          BOOLEAN NOT NULL DEFAULT FALSE,                  -- INDICADOR DE PRODUCTO EN ZONA DE ESTANTES 
    producMos          BOOLEAN NOT NULL DEFAULT FALSE,                  -- INDICADOR DE PRODUCTO MOSTRARIO PARA CLIENTES  
    producAct          BOOLEAN NOT NULL DEFAULT TRUE,                   -- INDICADOR DE PRODUCTO ACTIVO TRUE O NO ACTIVO FALSE
    producMen          DECIMAL(6,0) NOT NULL DEFAULT 0,                 -- CONTADOR DE UNIDADES DE PRODUCTO QUE HAN SIDO DESCONTADAS A LA FUERZA
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (producCod),
    FOREIGN KEY (idTipoPro) REFERENCES tipoproducto(tipoProId),
    FOREIGN KEY (idLinea) REFERENCES linea(lineaId),
    FOREIGN KEY (idMarca) REFERENCES marca(marcaId),
    FOREIGN KEY (nomEstant, numBandeja, codSeccion) REFERENCES seccion(nomEstant, numBandeja, seccionCod)
);

-- TABLA DE CLIENTES
CREATE TABLE cliente
(
    clientDoc          VARCHAR(10) NOT NULL,                            -- DOCUMENTO IDENTIFICADOR DEL CLIENTE. TAMBIÉN ES SU USUARIO PARA LOGEARSE
    idCiudad           DECIMAL(5,0) NOT NULL,                           -- FORÁNEA CIUDAD
    clientNom          VARCHAR(50) NOT NULL,                            -- NOMBRE COMPLETO DEL CLIENTE
    clientDir          VARCHAR(80) NOT NULL,                            -- DIRECCIÓN DEL CLIENTE
    clientTel          VARCHAR(10) NOT NULL,                            -- TELÉFONO DEL CLIENTE
    clientEma          VARCHAR(50) NOT NULL,                            -- EMAIL/ CORREO DEL CLIENTE
    clientCon          VARCHAR(300) NOT NULL,                           -- CONTRASEÑA DEL CLIENTE PARA LOGEARSE
    clientPun          DECIMAL(5,0) NOT NULL DEFAULT 0,                 -- PUNTOS POR COMPRAS. POR CADA 1000 PESOS SE LE DARÁ 1 PUNTO AL CLIENTE
    clientAct          BOOLEAN NOT NULL DEFAULT TRUE,                   -- INDICADOR DE CLIENTE ACTIVO TRUE O NO ACTIVO FALSE
    sesionActiva       BOOLEAN NOT NULL DEFAULT FALSE,                  -- INDICADOR DE SESIÓN ACTIVA
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (clientDoc),
    FOREIGN KEY (idCiudad) REFERENCES ciudad(ciudadId)
);

-- TABLA DE USUARIOS (MENSAJEROS, VENDEDORES, BODEGUEROS)
CREATE TABLE usuario
(
    usuarioDoc          VARCHAR(10) NOT NULL,                           -- DOCUMENTO IDENTIFICADOR DEL USUARIO. TAMBIÉN ES SU USUARIO PARA LOGEARSE
    usuarioRol          VARCHAR(9) NOT NULL,                            -- ROL DEL USUARIO EN EL SISTEMA
    usuarioNom          VARCHAR(50) NOT NULL,                           -- NOMBRE DEL USUARIO
    usuarioDir          VARCHAR(80) NOT NULL,                           -- DIRECCIÓN DEL USUARIO
    usuarioTel          VARCHAR(10) NOT NULL,                           -- TELÉFONO DEL USUARIO
    usuarioEma          VARCHAR(30) NOT NULL,                           -- EMAIL/ CORREO DEL USUARIO
    usuarioCon          VARCHAR(300) NOT NULL,                          -- CONTRASEÑA DEL USUARIO PARA LOGEARSE
    usuarioAct          BOOLEAN NOT NULL DEFAULT TRUE,                  -- INDICADOR DE USUARIO ACTIVO TRUE O NO ACTIVO FALSE
    sesionActiva        BOOLEAN NOT NULL DEFAULT FALSE,                 -- INDICADOR DE SESIÓN ACTIVA
    usr_insert          VARCHAR(15) NOT NULL,                           -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol      VARCHAR(15) NOT NULL,                           -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert          TIMESTAMP NOT NULL DEFAULT NOW(),               -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update          VARCHAR(15),                                    -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol      VARCHAR(15),                                    -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update          TIMESTAMP,                                      -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (usuarioDoc, usuarioRol)
);


-- TABLA PARA LA VENTA
CREATE TABLE venta
(
    ventaNum        DECIMAL(5,0) NOT NULL,                             -- NÚMERO IDENTIFICADOR DE LA VENTA
    docClient       VARCHAR(10) NOT NULL,                              -- FORÁNEA DOCUMENTO CLIENTE
    departamento    VARCHAR(40) NOT NULL,                              -- DEPARTAMENTO DEL CLIENTE
    ciudad          VARCHAR(40) NOT NULL,                              -- CIUDAD DEL CLIENTE
    tipopago        VARCHAR(20) NOT NULL,                              -- MODO DE PAGO
    ventaRutFac     VARCHAR(50) DEFAULT NULL,                          -- RUTA DEL DESTINO DE LA FACTURA
    ventaRec        BOOLEAN NOT NULL DEFAULT FALSE,                    -- EL VALOR DE LA VENTA FUE RECAUDADO O NO
	ventaPlaRec     TIMESTAMP NOT NULL DEFAULT NOW(),                  -- PLAZO PARA RECAUDAR EL VALOR DE LA VENTA
    ventaRutRec     VARCHAR(50) DEFAULT NULL,                          -- RUTA DEL DESTINO DEL COBRO DE LA FACTURA, SI ES EN TARJETA O TRANSFERENCIA BANCO
    ventaDom        BOOLEAN NOT NULL DEFAULT FALSE,                    -- CLIENTE REQUIERE DOMICILIO O NO
    ventaCan        BOOLEAN NOT NULL DEFAULT FALSE,                    -- INDICADOR DE VENTA CANCELADA TRUE O NO CANCELADA FALSE
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (ventaNum),
    FOREIGN KEY (docClient) REFERENCES cliente(clientDoc)
);

-- TABLA PARA EL DETALLL DE LA VENTA
CREATE TABLE detalleventa
(
    numVenta            DECIMAL(5,0) NOT NULL,                         -- FORÁNEA NÚMERO VENTA
    codProduc           VARCHAR(30) NOT NULL,                          -- FORÁNEA CODIGO PRODUCTO
    detVentaCan         DECIMAL(3,0) NOT NULL,                         -- CANTIDAD DE PRODUCTO DEL DETALLE DE LA VENTA
    precioProduc        DECIMAL(8,0) NOT NULL,                         -- VALOR UNITARIO PARA VENTA DEL PRODUCTO
    detVentaDes         DECIMAL(6,0) NOT NULL,                         -- DESCUENTO APLICADO AL PRODUCTO
    detVentaValPar      DECIMAL(8,0) NOT NULL,                         -- VALOR PARCIAL MONETARIO DEL DETALLE DE LA VENTA
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (numVenta, codProduc),
    FOREIGN KEY (numVenta) REFERENCES venta(ventaNum) ON DELETE CASCADE,
    FOREIGN KEY (codProduc) REFERENCES producto(producCod)
);

-- TABLA DE REDENCIÓN DE PUNTOS DEL CLIENTE
CREATE TABLE redencionpuntos
(
    redencNum          DECIMAL(2,0) NOT NULL,                          -- NÚMERO IDENTIFICADOR DE LA REDENCIÓN DE PUNTOS DEL CLIENTE
    numVenta           DECIMAL(5,0) NOT NULL,                          -- FORÁNEA VENTA
    redencPunRed       DECIMAL(2,0) NOT NULL,                          -- CANTIDAD DE PUNTOS REDIMIDOS POR EL CLIENTE
    redencDes          BOOLEAN NOT NULL,                               -- INDICADOR DE REDENCIÓN DESCUENTO TRUE Y SI NO, ES DOMICILIO FALSE
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (redencNum),
    FOREIGN KEY (numVenta) REFERENCES venta(ventaNum)
);

-- TABLA PARA EMPRESA DE TRANSPORTE
CREATE TABLE empresatransporte
(
    empreTraNit         VARCHAR(10) NOT NULL,                           -- NIT DE LA EMPRESA DE TRANSPORTE
    empreTraNom         VARCHAR(25) NOT NULL,                           -- NOMBRE DE LA EMPRESA DE TRANSPORTE
    empreTraTel         VARCHAR(10) NOT NULL,                           -- TELÉFONO DE LA EMPRESA DE TRANSPORTE
    empreTraAct         BOOLEAN NOT NULL DEFAULT TRUE,                  -- INDICADOR DE EMPRESA ACTIVA TRUE O NO ACTIVA FALSE
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (empreTraNit)
);

-- TABLA DE ENVÍO
CREATE TABLE envio
(
    envioNum                DECIMAL(7,0) NOT NULL,                          -- NÚMERO IDENTIFICADOR DEL ENVÍO
    numVenta                DECIMAL(5,0) NOT NULL,                          -- FORÁNEA VENTA
    docUsuario	            VARCHAR(10) NULL DEFAULT NULL,                  -- FORÁNEA MENSAJERO
    rolUsuario              VARCHAR(15) NULL DEFAULT NULL,                  -- FORÁNEA ROL MENSAJERO
    idCiudad                DECIMAL(5,0) NOT NULL,                          -- FORÁNEA MUNICIPIO DE DESTINO
    nitEmpreTra             VARCHAR(10) DEFAULT NULL,                       -- FORÁNEA EMPRESA TRANSPORTE
    envioDocDes             VARCHAR(10) NOT NULL,                           -- DOCUMENTO DEL DESTINARIO DEL ENVÍO
    envioNomDes             VARCHAR(50) NOT NULL,                           -- NOMBRE DEL DESTINARIO DEL ENVÍO
    envioDirDes             VARCHAR(80) NOT NULL,                           -- DIRECCIÓN DE DESTINO DEL ENVÍO
    envioTelDes             VARCHAR(10) NOT NULL,                           -- TELÉFONO DEL DESTINARIO DEL ENVÍO
    envioPre                DECIMAL(5,0) NOT NULL,                          -- PRECIO DEL ENVÍO
    envioObs                VARCHAR(150) DEFAULT NULL,                      -- OBSERVACIONES DEL ENVÍO
    envioSal                BOOLEAN NOT NULL DEFAULT FALSE,                 -- INDICADOR DE SALIDA DEL ENVÍO. SALIÓ TRUE, NO SALIÓ FALSE
    fec_salida              TIMESTAMP DEFAULT NULL,                    -- FECHA EN LA QUE SE SALIÓ EL ENVÍO
    envioEnt                BOOLEAN NOT NULL DEFAULT FALSE,                 -- INDICADOR DE ENTREGA DEL ENVÍO. ENTREGADO TRUE, NO ENTREGADO FALSE
    fec_entrega             TIMESTAMP DEFAULT NULL,                    -- FECHA EN LA QUE SE ENTREGÓ EL ENVÍO
    envioRut                VARCHAR(50) DEFAULT NULL,                       -- RUTA DE ACCESO A GUÍA DE ENVÍO NACIONAL
    usr_insert              VARCHAR(15) NOT NULL,                           -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol          VARCHAR(15) NOT NULL,                           -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert              TIMESTAMP NOT NULL DEFAULT NOW(),               -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update              VARCHAR(15),                                    -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol          VARCHAR(15),                                    -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update              TIMESTAMP,                                      -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO 
    PRIMARY KEY (envioNum),
    FOREIGN KEY (numVenta) REFERENCES venta(ventaNum),
	FOREIGN KEY (docUsuario, rolUsuario) REFERENCES usuario(usuarioDoc, usuarioRol),
    FOREIGN KEY (idCiudad) REFERENCES ciudad(ciudadId),
    FOREIGN KEY (nitEmpreTra) REFERENCES empresatransporte(empreTraNit)
);

-- TABLA DE PEDIDO A PROVEEDOR
CREATE TABLE pedidoproveedor
(
    pedidoNum               DECIMAL(5,0) NOT NULL,                       -- NÚMERO IDENTIFICADOR DEL PEDIDO AL PROVEEDOR
    nitProvee               VARCHAR(10) NOT NULL,                        -- FORÁNEA PROVEEDOR
    tipopago                VARCHAR(20) NOT NULL,                        -- MODO DE PAGO
    pedidoTotal             DECIMAL(9,0) NOT NULL,                       -- VALOR TOTAL DEL PEDIDO
    pedidoIva               DECIMAL(9,0) NOT NULL,                       -- VALOR DEL IVA DEL PEDIDO
    pedidoRutPag            VARCHAR(50) DEFAULT NULL,                    -- RUTA DE ACCESO AL VOUCHER DE PAGO AL PROVEEDOR
    pedidoPag               BOOLEAN NOT NULL,                            -- EL PEDIDO FUE PAGADO AL PROVEEDOR TRUE, SI NO FALSE
	PagoPlazo               TIMESTAMP NOT NULL DEFAULT NOW(),            -- PLAZO PARA PAGAR EL VALOR DEL PEDID.
    usr_insert         VARCHAR(15) NOT NULL,                            -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                            -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                     -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                     -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                       -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (pedidoNum, nitProvee),
    FOREIGN KEY (nitProvee) REFERENCES proveedor(proveeNit)
);

-- TABLA PARA EL DETALLE DEL PEDIDO
CREATE TABLE detallepedido
(
    numPedido               DECIMAL(5,0) NOT NULL,                       -- FORÁNEA NÚMERO PEDIDO
    nitProvee               VARCHAR(10) NOT NULL,                        -- FORÁNEA PROVEEDOR
    codProduc               VARCHAR(30) NOT NULL,                        -- FORÁNEA CODIGO PRODUCTO
    detPedCan               DECIMAL(3,0) NOT NULL,                       -- CANTIDAD DE PRODUCTO DEL DETALLE DEL PEDIDO
    detPedCos               DECIMAL(7,0) NOT NULL,                       -- COSTO UNITARIO DEL PRODUCTO
    detPedValPar            DECIMAL(8,0) NOT NULL,                       -- VALOR PARCIAL MONETARIO DEL DETALLE DEL PEDIDO
    usr_insert         VARCHAR(15) NOT NULL,                             -- USUARIO QUIEN INSERTÓ EL REGISTRO
    usr_insert_rol     VARCHAR(15) NOT NULL,                             -- ROL DEL USUARIO QUIEN INSERTÓ EL REGISTRO
    fec_insert         TIMESTAMP NOT NULL DEFAULT NOW(),                 -- FECHA EN LA QUE SE INSERTÓ EL REGISTRO
    usr_update         VARCHAR(15),                                      -- USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    usr_update_rol     VARCHAR(15),                                      -- ROL DEL USUARIO QUIEN ACTUALIZÓ EL REGISTRO
    fec_update         TIMESTAMP,                                        -- FECHA EN LA QUE SE ACTUALIZÓ EL REGISTRO
    PRIMARY KEY (numPedido, nitProvee, codProduc),
    FOREIGN KEY (numPedido, nitProvee) REFERENCES pedidoproveedor(pedidoNum, nitProvee),
    FOREIGN KEY (codProduc) REFERENCES producto(producCod)  
);