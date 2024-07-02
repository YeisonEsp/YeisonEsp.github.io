CREATE OR REPLACE FUNCTION fun_insert_observacion(wnum_envio envio.envionum%TYPE,
                                                    wobs_envio envio.envioobs%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wenvio envio.envioNum%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT envioNum INTO wenvio FROM envio WHERE envioNum=wnum_envio FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El envío no se encuentra registrado';
            RETURN wmessage;
        END IF;
        UPDATE envio SET envioObs=wobs_envio 
        WHERE envioNum = wnum_envio;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la inserción de la observación del envío';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;