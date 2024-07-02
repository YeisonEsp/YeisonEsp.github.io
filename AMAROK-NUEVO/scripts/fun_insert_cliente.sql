CREATE OR REPLACE FUNCTION fun_insert_cliente(wdoc_cliente cliente.clientDoc%TYPE,wid_ciudad ciudad.ciudadId%TYPE,
											wnom_cliente cliente.clientNom%TYPE,
                                            wdir_cliente cliente.clientDir%TYPE,wtel_cliente cliente.clientTel%TYPE,
											wema_cliente cliente.clientEma%TYPE,
											wcon_cliente cliente.clientCon%TYPE, wuser_insert cliente.usr_insert%TYPE,
                                            wuser_insert_rol  cliente.usr_insert_rol%TYPE) RETURNS VARCHAR AS
$BODY$
	DECLARE wcliente cliente.clientDoc%TYPE;
    DECLARE wciudad ciudad.ciudadId%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT clientDoc INTO wcliente FROM cliente WHERE clientDoc=wdoc_cliente;
        IF FOUND THEN
            wmessage = 'Este documento se encuentra ya registrado en la bd, olvídelo';
            RETURN wmessage;
        END IF;
        SELECT ciudadId INTO wciudad FROM ciudad WHERE ciudadId=wid_ciudad;
        IF NOT FOUND THEN
            wmessage = 'Esta ciudad no se encuentra registrada';
            RETURN wmessage;
        END IF;
        INSERT INTO cliente(clientDoc,idciudad,clientNom,clientDir,clientTel,clientEma,clientCon,usr_insert,usr_insert_rol) 
        VALUES(wdoc_cliente,wid_ciudad, wnom_cliente, wdir_cliente, wtel_cliente,
								wema_cliente, MD5(wcon_cliente), wuser_insert, wuser_insert_rol);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la inserción';
            RETURN wmessage;
        END IF;

    END;
$BODY$
LANGUAGE PLPGSQL;