CREATE OR REPLACE FUNCTION fun_disable_sesion_otros(wid usuario.usuarioDoc%TYPE, wrol usuario.usuarioRol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wsesion usuario.sesionActiva%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT sesionActiva INTO wsesion FROM usuario WHERE usuarioDoc=wid AND usuarioRol=wrol FOR UPDATE;
        UPDATE usuario SET sesionActiva=FALSE WHERE usuarioDoc=wid AND usuarioRol=wrol;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la desactivación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;