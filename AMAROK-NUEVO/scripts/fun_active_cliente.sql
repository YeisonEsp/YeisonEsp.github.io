CREATE OR REPLACE FUNCTION fun_active_cliente(wdoc_cliente cliente.clientdoc%TYPE,
                                                wuser_update cliente.usr_update%TYPE,
                                                wuser_update_rol  cliente.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wcliente cliente.clientDoc%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT clientDoc INTO wcliente FROM cliente WHERE clientDoc=wdoc_cliente FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El cliente no se encuentra registrado';
            RETURN wmessage;
        END IF;
        UPDATE cliente SET clientAct=TRUE,
                                usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
        WHERE clientdoc = wdoc_cliente;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la activación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;