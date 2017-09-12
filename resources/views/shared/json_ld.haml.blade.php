%script{type: => "application/ld+json"}
  "@context": {
    "name": "http://schema.org/name",
    "description": "http://schema.org/description",
    "geo": "http://schema.org/geo",
    "latitude": {
      "@id": "http://schema.org/latitude",
      "@type": "xsd:float"
    },
    "longitude": {
      "@id": "http://schema.org/longitude",
      "@type": "xsd:float"
    },
    "xsd": "http://www.w3.org/2001/XMLSchema#"
  },
  "name": "#{@json_ld.name}",
  "description": "#{@json_ld.description}",
  "image": "http://www.civil.usherbrooke.ca/cours/gci215a/empire-state-building.jpg",
  "geo": {
    "latitude": "#{@json_ld.latitude}",
    "longitude": "#{@json_ld.longitude}"
  }
}
