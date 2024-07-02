CREATE OR REPLACE FUNCTION fun_assign_mensajero(  wnum_envio envio.envioNum%TYPE,
                                                wdoc_usuario usuario.usuariodoc%TYPE,
                                                wuser_update envio.usr_update%TYPE,
                                                wuser_update_rol  envio.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wreg_usuario RECORD;
    DECLARE wreg_envio RECORD;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT envioNum, numVenta INTO wreg_envio FROM envio WHERE envioNum=wnum_envio FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El envío no se encuentra registrado';
            RETURN wmessage;
        END IF;
        IF wreg_envio.numVenta < 0 THEN
            wmessage = 'La venta debe cobrarse para asignar un mensajero al envío';
            RETURN wmessage;
        END IF;
        SELECT usuarioDoc, usuarioAct INTO wreg_usuario FROM usuario WHERE usuarioDoc=wdoc_usuario AND usuariorol='Mensajero';
        IF NOT FOUND THEN
            wmessage = 'El mensajero no se encuentra registrado';
            RETURN wmessage;
        END IF;
        IF wreg_usuario.usuarioAct = false THEN
            wmessage = 'El mensajero no se encuentra activo en el sistema';
            RETURN wmessage;
        END IF;
        UPDATE envio SET docUsuario = wdoc_usuario,
                                rolUsuario = 'Mensajero',
                                envioSal = true,
                                fec_salida = now(),
                                usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
        WHERE envioNum = wnum_envio;
        IF NOT FOUND THEN
            wmessage = 'Error en la asignación';
            RETURN wmessage;
        END IF;
        RETURN wmessage;
    END;
$BODY$
LANGUAGE PLPGSQL;