CREATE OR REPLACE FUNCTION fun_active_usuario(wdoc_usuario usuario.usuariodoc%TYPE,
                                                wrol_usuario usuario.usuariorol%TYPE,
                                                wuser_update usuario.usr_update%TYPE,
                                                wuser_update_rol  usuario.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wusuario usuario.usuarioDoc%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT usuarioDoc INTO wusuario FROM usuario WHERE usuarioDoc=wdoc_usuario AND usuariorol=wrol_usuario FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El usuario no se encuentra registrado';
            RETURN wmessage;
        END IF;
        UPDATE usuario SET usuarioAct=TRUE,
                            usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
        WHERE usuariodoc = wdoc_usuario AND usuariorol=wrol_usuario;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la activación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;