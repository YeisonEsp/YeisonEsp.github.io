CREATE OR REPLACE FUNCTION fun_active_empresatransporte(wnit_empresatransporte empresatransporte.empreTranit%TYPE,
                                                wuser_update empresatransporte.usr_update%TYPE,
                                                wuser_update_rol  empresatransporte.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wempresatransporte empresatransporte.empreTranit%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT empreTranit INTO wempresatransporte FROM empresatransporte WHERE empreTranit=wnit_empresatransporte FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'La empresa de transporte no se encuentra registrado';
            RETURN wmessage;
        END IF;
        UPDATE empresatransporte SET empreTraAct=TRUE,
                            usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
        WHERE empreTranit = wnit_empresatransporte;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la activación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;