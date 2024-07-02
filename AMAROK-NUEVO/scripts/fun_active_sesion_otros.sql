CREATE OR REPLACE FUNCTION fun_active_sesion_otros(wid usuario.usuarioDoc%TYPE, wrol usuario.usuarioRol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wsesion usuario.sesionActiva%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT sesionActiva INTO wsesion FROM usuario WHERE usuarioDoc=wid AND usuarioRol=wrol FOR UPDATE;
        UPDATE usuario SET sesionActiva=TRUE WHERE usuarioDoc=wid AND usuarioRol=wrol;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la activación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;