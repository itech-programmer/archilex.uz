package com.sayanbera.dictionary.domain.model

enum class DictionaryCategory(
    val apiValue: String,
    val displayName: String
) {
    GENERAL("general", "British / American"),
    ARCHITECTURE("architecture", "Architecture"),
    CONSTRUCTION("construction", "Construction")
}
