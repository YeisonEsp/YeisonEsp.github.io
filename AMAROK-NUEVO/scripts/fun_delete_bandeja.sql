CREATE OR REPLACE FUNCTION fun_delete_bandeja(wnum_bandeja bandeja.bandejaNum%TYPE,
                                                wnom_estante bandeja.nomEstant%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wbandeja bandeja.bandejaNum%TYPE;
    BEGIN
        wmessage='00000';
        SELECT bandejaNum INTO wbandeja FROM bandeja WHERE bandejaNum = wnum_bandeja AND nomEstant = wnom_estante FOR UPDATE;
        DELETE FROM bandeja
        WHERE  bandejaNum = wnum_bandeja AND nomEstant = wnom_estante;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage='Error al eliminar';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;