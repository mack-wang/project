package com.fypool.config;


import com.fypool.model.*;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.data.rest.core.config.RepositoryRestConfiguration;
import org.springframework.data.rest.webmvc.config.RepositoryRestConfigurerAdapter;
import org.springframework.data.web.HateoasPageableHandlerMethodArgumentResolver;

@Configuration
public class ExposeEntityIdRestConfiguration extends RepositoryRestConfigurerAdapter {

    @Override
    public void configureRepositoryRestConfiguration(RepositoryRestConfiguration config) {
        config.exposeIdsFor(MhCity.class);
        config.exposeIdsFor(CertificateKind.class);
        config.exposeIdsFor(Languages.class);
        config.exposeIdsFor(LanguageGroup.class);
        config.exposeIdsFor(SkilledField.class);
        config.exposeIdsFor(SkilledUsage.class);
        config.exposeIdsFor(PriceRange.class);
    }


}