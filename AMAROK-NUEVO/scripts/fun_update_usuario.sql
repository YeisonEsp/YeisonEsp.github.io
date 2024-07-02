CREATE OR REPLACE FUNCTION fun_update_usuario(wdoc_usuario usuario.usuarioDoc%TYPE,
                                            wrol_usuario usuario.usuarioRol%TYPE,
											wnom_usuario usuario.usuarioNom%TYPE,
                                            wdir_usuario usuario.usuarioDir%TYPE,wtel_usuario usuario.usuarioTel%TYPE,
											wema_usuario usuario.usuarioEma%TYPE, wuser_update usuario.usr_update%TYPE,
                                            wuser_update_rol  usuario.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wusuario usuario.usuarioDoc%TYPE;
    BEGIN
        wmessage='00000';
        SELECT usuarioDoc INTO wusuario FROM usuario WHERE usuarioDoc = wdoc_usuario AND usuarioRol=wrol_usuario FOR UPDATE;
        UPDATE usuario SET      usuarioNom       = wnom_usuario,
                                usuarioDir       = wdir_usuario,
                                usuarioTel       = wtel_usuario,
                                usuarioema       = wema_usuario,
                                usr_update       = wuser_update,
                                usr_update_rol   = wuser_update_rol,
                                fec_update       = now()
        WHERE usuarioDoc = wdoc_usuario AND usuarioRol=wrol_usuario;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;