CREATE OR REPLACE FUNCTION fun_active_sesion_cliente(wid cliente.clientDoc%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wsesion cliente.sesionActiva%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT sesionActiva INTO wsesion FROM cliente WHERE clientDoc=wid FOR UPDATE;
        UPDATE cliente SET sesionActiva=TRUE WHERE clientDoc=wid;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la activación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;