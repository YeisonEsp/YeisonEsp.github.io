CREATE OR REPLACE FUNCTION fun_insert_usuario(wdoc_usuario usuario.usuarioDoc%TYPE,
                                            wrol_usuario usuario.usuarioRol%TYPE,
											wnom_usuario usuario.usuarioNom%TYPE,
                                            wdir_usuario usuario.usuarioDir%TYPE,wtel_usuario usuario.usuarioTel%TYPE,
											wema_usuario usuario.usuarioEma%TYPE,
											wcon_usuario usuario.usuarioCon%TYPE,
                                            wuser_insert usuario.usr_insert%TYPE,
                                            wuser_insert_rol  usuario.usr_insert_rol%TYPE) RETURNS VARCHAR AS
$BODY$
	DECLARE wusuario record;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT usuarioDoc, usuarioRol INTO wusuario FROM usuario WHERE usuarioDoc=wdoc_usuario AND usuarioRol=wrol_usuario;
        IF FOUND THEN
            wmessage = 'Este usuario se encuentra ya registrado en la bd, olvídelo';
            RETURN wmessage;
        END IF;
        INSERT INTO usuario(usuarioDoc,usuarioRol,usuarioNom,usuarioDir,usuarioTel,usuarioEma,usuarioCon,usr_insert,usr_insert_rol) 
        VALUES(wdoc_usuario, wrol_usuario, wnom_usuario, wdir_usuario, wtel_usuario,
								wema_usuario, MD5(wcon_usuario), wuser_insert, wuser_insert_rol);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la inserción';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;