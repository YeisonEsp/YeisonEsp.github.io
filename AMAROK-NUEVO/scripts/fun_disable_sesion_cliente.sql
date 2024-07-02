CREATE OR REPLACE FUNCTION fun_disable_sesion_cliente(wid cliente.clientDoc%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wsesion cliente.sesionActiva%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT sesionActiva INTO wsesion FROM cliente WHERE clientDoc=wid FOR UPDATE;
        UPDATE cliente SET sesionActiva=FALSE WHERE clientDoc=wid;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la desactivación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;