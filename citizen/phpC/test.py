import folium
from folium import plugins

# Create a map object with Google Maps tiles
m = folium.Map(location=[-20.2702848, 57.769984], zoom_start=12, tiles='https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', attr='Map data © Google')

# Create a feature group layer
search_layer = folium.FeatureGroup(name='Search Layer')
m.add_child(search_layer)

# Add a marker to the search layer
folium.Marker(
    location=[-20.2702848, 57.769984],
    popup='Mauritius',
    icon=folium.Icon(icon='star', prefix='fa', color='red')
).add_to(search_layer)

# Add search control
search_control = plugins.Search(layer=search_layer)
m.add_child(search_control)

# Save the map to an HTML file
m.save('map.html')
