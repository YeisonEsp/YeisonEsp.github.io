CREATE OR REPLACE FUNCTION fun_disable_usuario(wdoc_usuario usuario.usuarioDoc%TYPE, wrol_usuario usuario.usuarioRol%TYPE,
                                                wuser_update usuario.usr_update%TYPE,
                                                wuser_update_rol  usuario.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wusuario RECORD;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT usuarioDoc, usuarioRol INTO wusuario FROM usuario WHERE usuarioDoc=wdoc_usuario AND usuarioRol=wrol_usuario FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El usuario no se encuentra registrado';
            RETURN wmessage;
        END IF;
        UPDATE usuario SET usuarioAct = FALSE,
                            sesionActiva = FALSE,
                                usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
        WHERE usuarioDoc = wdoc_usuario AND usuarioRol=wrol_usuario;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la desactivación';
            RETURN wmessage;
        END IF;
        
    END;
$BODY$
LANGUAGE PLPGSQL;