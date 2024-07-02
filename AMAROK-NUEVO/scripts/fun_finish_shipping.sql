CREATE OR REPLACE FUNCTION fun_finish_shipping(wnum_envio envio.envionum%TYPE,
                                                wempresa envio.nitEmpreTra%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wenvio envio.envioNum%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        SELECT envioNum INTO wenvio FROM envio WHERE envioNum=wnum_envio FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El envío no se encuentra registrado';
            RETURN wmessage;
        END IF;
        IF wempresa IS NULL OR wempresa='' THEN
            UPDATE envio SET    envioEnt=TRUE,
                                fec_entrega=now()
            WHERE envioNum = wnum_envio;
            IF FOUND THEN
                wmessage = TO_CHAR(wnum_envio, 'FM99999');
                RETURN wmessage;
            ELSE
                wmessage = 'Error en la finalización del envío';
                RETURN wmessage;
            END IF;
        ELSE
            UPDATE envio SET    nitEmpreTra=wempresa,
                            envioEnt=TRUE,
                            fec_entrega=now()
            WHERE envioNum = wnum_envio;
            IF FOUND THEN
                wmessage = TO_CHAR(wnum_envio, 'FM99999');
                RETURN wmessage;
            ELSE
                wmessage = 'Error en la finalización del envío';
                RETURN wmessage;
            END IF;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;