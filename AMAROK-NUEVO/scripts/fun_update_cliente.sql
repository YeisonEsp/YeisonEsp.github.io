CREATE OR REPLACE FUNCTION fun_update_cliente(wdoc_cliente cliente.clientDoc%TYPE,
                                            wciu_cliente ciudad.ciudadId%TYPE,
											wnom_cliente cliente.clientNom%TYPE,
                                            wdir_cliente cliente.clientDir%TYPE,wtel_cliente cliente.clientTel%TYPE,
											wema_cliente cliente.clientEma%TYPE, wuser_update cliente.usr_update%TYPE,
                                            wuser_update_rol  cliente.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wciudad ciudad.ciudadId%TYPE;
    DECLARE wcliente cliente.clientDoc%TYPE;
    BEGIN
        wmessage='00000';
        SELECT clientDoc INTO wcliente FROM cliente WHERE clientDoc = wdoc_cliente FOR UPDATE;
        SELECT ciudadId INTO wciudad FROM ciudad WHERE ciudadId=wciu_cliente;
        IF NOT FOUND THEN
            wmessage = 'La ciudad no se encuentra registrada';
            RETURN wmessage;
        END IF;
        UPDATE cliente SET      clientNom       = wnom_cliente,
								idciudad		= wciu_cliente,
                                clientDir       = wdir_cliente,
                                clientTel       = wtel_cliente,
                                clientema       = wema_cliente,
                                usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
        WHERE clientDoc = wdoc_cliente;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;