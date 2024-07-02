CREATE OR REPLACE FUNCTION fun_delete_linea( wid_linea	linea.lineaId%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wlin linea.lineaId%TYPE;
    DECLARE wmessage VARCHAR;
    DECLARE wlinea linea.lineaId%TYPE;
    BEGIN
        wmessage='00000';
        SELECT lineaId INTO wlinea FROM linea WHERE lineaId=wid_linea FOR UPDATE;
        SELECT idlinea INTO wlin FROM producto WHERE idlinea=wid_linea;
        IF  NOT FOUND THEN
            DELETE FROM linea
            WHERE lineaId = wid_linea;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage='Error al eliminar';
                RETURN wmessage;
            END IF;
        ELSE
            wmessage='La línea no se puede eliminar porque está asociada a algún producto';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;