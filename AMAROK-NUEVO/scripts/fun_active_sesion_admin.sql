CREATE OR REPLACE FUNCTION fun_active_sesion_admin() RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wsesion parametros.sesionActiva%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT sesionActiva INTO wsesion FROM parametros FOR UPDATE;
        UPDATE parametros SET sesionActiva=TRUE;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la activación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;