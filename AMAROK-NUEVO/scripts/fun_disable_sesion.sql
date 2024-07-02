CREATE OR REPLACE FUNCTION fun_disable_sesion() RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wsesion parametros.sesionActiva%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT sesionActiva INTO wsesion FROM parametros FOR UPDATE;
        UPDATE parametros SET sesionActiva=FALSE;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la desactivación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;